<?php

namespace App\Notifications\Reservation;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BankDepositSlipUploadedNotification extends Notification
{
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice, $main)
    {
        $this->invoice = $invoice;
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
        return (new MailMessage)
                    ->subject(config('app.name') . ': Bank Deposit Upload')
                    ->greeting('Hello '.$notifiable->first_name.'!')
                    ->from('no-reply@visita.com')
                    ->line('Bank Deposit is uploaded to Invoice with Reference Number of '. $this->invoice->reference_code)
                    ->line('Reservation Details')
                    ->line('Main Contact Person: '. $this->main->renderFullname())
                    ->line('Destination: '. $this->invoice->book->destination->name)
                    ->line('Experience: '. $this->invoice->book->allocation->name)
                    ->line('Kindly review the uploaded deposit slip, thank you!');
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
            'message' => 'Bank Deposit is uploaded',
            'title' => 'Bank Deposit is uploaded to Invoice with Reference Number of '. $this->invoice->reference_code,
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
