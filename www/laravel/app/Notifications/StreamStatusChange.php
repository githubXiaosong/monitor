<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StreamStatusChange extends Notification
{
    use Queueable;

    protected $stream_id;
    protected $per_status;
    protected $to_status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($stream_id,$per_status,$to_status)
    {

        //
        $this->stream_id = $stream_id;
        $this->per_status = $per_status;
        $this->to_status = $to_status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!');
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
            'stream_id' => $this->stream_id,
            'per_status' => $this->per_status,
            'to_status' => $this->to_status
        ];
    }
}
