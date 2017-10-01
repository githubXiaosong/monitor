<?php

namespace App\Notifications;

use App\Server;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServerError extends Notification implements ShouldQueue
{
    use Queueable;

    public $id;
    protected $msg;
    protected $ip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id, $msg)
    {
        //
        $this->id = $id;
        $this->msg = $msg;
        $this->ip = Server::findOrFail($id)->ip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->error()
            ->subject('截图服务器 ' . $this->ip . "发生错误")
            ->line('服务器 ' . $this->ip . " 发生错误 " . "  Error Msg:" . $this->msg);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'ip' => $this->ip,
            'msg' => $this->msg,
        ];
    }
}
