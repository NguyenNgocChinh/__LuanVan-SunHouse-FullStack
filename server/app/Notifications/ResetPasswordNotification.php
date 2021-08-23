<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $url;
    public $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($url, $name)
    {
        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return ( new MailMessage )
           ->from(env('MAIL_USERNAME'), 'SunHouse')
           ->subject( 'Đặt lại mật khẩu' )
           ->greeting('Xin chào '.$this->name)
           ->line( "Chào bạn, chúng tôi nhận thấy rằng bạn có yêu cầu thay đổi mật khẩu. Hãy bấm vào nút đặt lại mật khẩu đề tiến hành cập nhật mật khẩu mới." )
           ->action( 'Đặt lại mật khẩu', $this->url )
           ->line( 'Cảm ơn!' );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
