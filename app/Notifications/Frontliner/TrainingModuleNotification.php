<?php

namespace App\Notifications\Frontliner;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TrainingModuleNotification extends Notification 
{
    use Queueable;

    public $title;
    public $description;
    public $path;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $description, $path)
    {
        $this->title = $title;
        $this->description = $description;
        $this->path = $path;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->subject(config('app.name') . ': ' . $this->title)
            ->greeting('Hello ' . $notifiable->fullname . ',')
            ->line('Title: ' . $this->title)
            ->line('Description: ' . $this->description)
            ->line(url($this->path));
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
            'message' => $this->description,
            'title' => $this->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
