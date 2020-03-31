<?php

namespace App\Listeners;

use PRAXXYSEcommerce\PayPal\Events\PayPalNotified;
use Illuminate\Support\Facades\Log;

use App\Notifications\Web\Paypal\UserInvoicePaid;
use App\Notifications\Admin\Paypal\AdminInvoicePaid;

use App\Models\Invoices\Invoice;
use App\Models\Users\Admin;

class ProcessPayPal
{

    protected $result;
    protected $invoice;

    /**
     * Handle the event.
     *
     * @param  \PRAXXYSEcommerce\PayPal\Events\PayPalNotified  $event
     * @return void
     */
    public function handle(PayPalNotified $event)
    {

        Log::info('Dispatching PayPalNotified...');

        # dd($event->result):
        # [
        #   "reference_code" => "(your invoice reference)",
        #   "transaction_code" => "Transaction code from PayPal",
        # ]
        $this->result = $event->result;

        # PROCESS YOUR ACTIONS HERE:
        
        $this->processInvoice();
        $this->notifyUser();
        $this->notifyAdmin();
    }


    /* * * * * * * * * * * * * * *
     * SAMPLE CODE FOR REFERENCE *
     * * * * * * * * * * * * * * */


    private function processInvoice() {

        \DB::beginTransaction();

        # will cause error if no code is there
        $this->invoice = Invoice::where('reference_code', $this->result['reference_code'])->first();
        $this->invoice->is_paid = true;
        $this->invoice->payment_code = $this->result['transaction_code'];

        $this->invoice->save();

        \DB::commit();

    }

    private function notifyUser()
    {
        $this->invoice->bookable->notify(new UserInvoicePaid($this->invoice));
    }

    private function notifyAdmin()
    {
        $admins = Admin::all();

        foreach ($admins as $admin)
        {
            $admin->notify(new AdminInvoicePaid($this->invoice));
        }
    }


}