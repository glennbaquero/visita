<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use Carbon\Carbon;

class BankDepositUploadApprove extends Notification
{
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice)
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
                ->subject(config('app.name') . ': ' . 'Visita Reservation Approved')
                ->greeting('Hello ' . $notifiable->renderName() . ',')
                ->line('Your reservation is approved.')
                ->line('Invoice Paid via Bank Deposit')
                ->line('Invoice Details : ')
                ->line('Reference # : '. $this->invoice->reference_code)
                ->line('Conservation Fee : '. $this->invoice->conservation_fee)
                ->line('Platform Fee : '. $this->invoice->platform_fee)
                ->line('Sub Total : '. $this->invoice->sub_total)
                ->line('Transaction Fee : '. $this->invoice->transaction_fee)
                ->line('Total : '. $this->invoice->grand_total)
                ->line('Reservation Details : ')
                ->line('Destination : '. $this->invoice->book->destination->name)
                ->line('Experience : '. $this->invoice->book->allocation->name)
                ->line('Number of Guests : '. $this->invoice->book->total_guest)
                ->line('Schedule : '. $this->invoice->book->scheduled_at->format('M d, Y'))
                ->line('Start time of the visit : '. Carbon::createFromFormat('H:i:s', $this->invoice->book->start_time)->format('h:i A'))
                ->line('Thank you!')
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
            'message' => 'Your reservation is approved via bank deposit!',
            'title' => 'Reservation Approved',
            'subject_id' => $notifiable->id, 
            'subject_type' => get_class($notifiable),
        ];
    }
}
