<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StreamError extends Notification implements ShouldQueue
{
    use Queueable;

    protected $stream_id;
    protected $status;
    protected $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($stream_id,$status,$msg)
    {
        //
        $this->stream_id = $stream_id;
        $this->status = $status;
        $this->msg = $msg;
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
            ->subject('流 ' . $this->stream_id . " 发生错误")
            ->line('流 ' . $this->stream_id . " 在". $this->status . "阶段发生错误 " . "  Error Msg:" .$this->msg);
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
            'stream_id' => $this->stream_id,
            'msg' => $this->msg,
            'status' => $this->msg
        ];
    }
}
