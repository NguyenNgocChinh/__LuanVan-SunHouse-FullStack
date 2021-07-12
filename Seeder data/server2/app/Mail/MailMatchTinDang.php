<?php

namespace App\Mail;

use App\Models\BaiDang;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailMatchTinDang extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $baidang;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, BaiDang $baiDang)
    {
        $this->user = $user;
        $this->baidang = $baiDang;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'SunHouse')
            ->subject('Tìm thấy tin đăng phù hợp')
            ->markdown('mails.matchTinDang')
            ->with([
                'name' => $this->user->name,
                'baidang' => $this->baidang,
            ]);
    }
}
