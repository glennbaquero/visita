<?php

namespace App\Notifications\Web\Bookings;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $title;
    public $description;
    public $destination;
    public $allocation;
    public $booking;
    public $main;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($destination, $allocation, $booking, $main, $notification)
    {
        $this->destination = $destination;
        $this->allocation = $allocation;
        $this->booking = $booking;
        $this->main = $main;
        $this->title = 'New Reservation';
        $this->description = 'A new reservation from user';
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
                ->line($this->description)
                ->line('Reservation Details : ')
                ->line('Book ID : '. $this->booking->id)
                ->line('Destination : '. $this->destination->name)
                ->line('Experience : '. $this->allocation->name)
                ->line('Main Contact Person : '. $this->main->first_name. ' '.$this->main->last_name);
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
