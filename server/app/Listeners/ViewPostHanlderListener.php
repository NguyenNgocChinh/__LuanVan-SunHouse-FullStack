<?php

namespace App\Listeners;

use App\Events\ViewPostHanlder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Session\Store;
use App\Models\BaiDang;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ViewPostHanlderListener
{
    private $session;
    private $post;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session, BaiDang $post)
    {
        $this->session = $session;
        $this->post = $post;
    }

    /**
     * Handle the event.
     *
     * @param  ViewPostHanlder  $event
     * @return void
     */
    public function handle($event)
    {
        $post = $event->post;
        Log::info("in handle");
        Log::info("session " . json_encode(session()->get('viewed_posts', [])));
        Log::info("Bài đăng đã được xem " . $this->isPostViewed($post));
	    if (!$this->isPostViewed($post))
	    {
            Log::info($post);
            Log::info("increement luotxem");
            $post->increment('luotxem');
	        $this->storePost($post);
	    }
    }

    private function isPostViewed($post)
	{
	    $viewed = $this->session->get('viewed_posts', []);
        Log::info("get post... " . array_key_exists($post->id, $viewed));
	    return array_key_exists($post->id, $viewed);
	}

	private function storePost($post)
	{
	    $key = 'viewed_posts.' . $post->id;

	    $this->session->put($key, time());
	}
}
