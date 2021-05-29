<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use OneSignal;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function get()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });


        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        // get all messages between the authenticated user and the selected user
        $messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $message = new Message();
        $message->from = Auth::user()->id;
        $message->to = $request->contact_id;
        $message->noidung = $request->text;
        $message->save();


        OneSignal::sendNotificationUsingTags(
            $message->noidung,
            array(
                ["field" => "tag", "key" => "user_id", "relation" => "=", "value" => $message->to],
            ),
            $url = 'http://localhost:3000/test',
            $data = null,
            $buttons = null,
            $schedule = null
        );

        broadcast(new NewMessage($message));

        return response()->json($message);
    }
}
