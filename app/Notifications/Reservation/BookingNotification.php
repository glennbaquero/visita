<?php

namespace App\Notifications\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $book;
    public $qr_path;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($book, $email)
    {
        $this->book = $book;
        $this->title = $email->title;
        $this->message = $email->message;
        $this->qr_path = "Download the QR here : ".url($this->book->renderImagePath('qr_code_path')).".";
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
                    ->subject(config('app.name') . ':'.$this->title)
                    ->greeting('Hello '.$notifiable->first_name.'!')
                    ->from('no-reply@visita.com')
                    ->line($this->message)
                    ->line($this->qr_path);
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
            'message' => $this->message,
            'title' => $this->title,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
