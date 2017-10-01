<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Test extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected  $type;
    protected  $title;
    protected  $content;

    public function __construct($type,$title,$content)
    {
        $this->title = $title;
        $this->content = $content;
    }



    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//
        return (new MailMessage)
            ->error()
            ->subject($this->title)
            ->line($this->content);

//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', 'https://laravel.com')
//                    ->line('Thank you for using our application!');
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
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content
        ];
    }


}
