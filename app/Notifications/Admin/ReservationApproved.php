<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationApproved extends Notification
{
    use Queueable;

    public $next_step;
    public $notification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($next_step, $notification)
    {
        $this->next_step = $next_step;
        $this->notification = $notification;
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
                ->subject(config('app.name') . ': ' . $this->notification->title)
                ->greeting('Hello ' . $notifiable->renderName() . ',')
                ->line($this->notification->message)
                ->line('Next step : '.$this->next_step)
                ->line('<a href="'.route('web.dashboard').'">View Dashboard</a>');
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
            'message' => $this->notification->message,
            'title' => $this->notification->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
