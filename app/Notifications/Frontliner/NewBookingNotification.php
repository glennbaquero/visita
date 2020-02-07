<?php

namespace App\Notifications\Frontliner;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $title;
    public $description;
    public $request;
    public $date;
    public $destination;
    public $allocation;
    public $book;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($destination, $allocation, $book, $main, $notification)
    {
        $this->destination = $destination;
        $this->allocation = $allocation;
        $this->book = $book;
        $this->main = $main;
        $this->title = $notification->title;
        $this->description = $notification->message;
        $this->date = Carbon::parse($book->scheduled_at)->format('M d, Y');
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
            ->line('Details of point person of the group ')
            ->line('Mr/Mrs/Ms.'. $this->main->first_name. ' '. $this->main->last_name)
            ->line('Email : '. $this->main->email)
            ->line('Contact Number : '. $this->main->contact_number)
            ->line('Visit Date : '.$this->date)
            ->line('For full details check the calendar in Visita Mobile App.');
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
