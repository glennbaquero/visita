<?php

namespace App\Http\Controllers\Admin\Invoices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

use App\Models\Invoices\Invoice;

use App\Notifications\Admin\ReservationApproved;
use App\Notifications\Admin\ReservationRejected;
use App\Notifications\Admin\BankDepositUploadRejected;
use App\Notifications\Admin\BankDepositUploadApprove;

class InvoiceController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
            $item = Invoice::withTrashed()->findOrFail($id);   
            $item->update(['is_approved' => $request->is_approved]);
        DB::commit();

        $main = $item->book->guests->where('main', true)->first();
        $user = $item->user;

        if($item->is_paypal_payment) {
            $main->notify(new ReservationApproved('Payment thru Paypal'));
            $user->notify(new ReservationApproved('Payment thru Paypal'));
        } else {
            $main->notify(new ReservationApproved('Upload Deposit Slip'));
            $user->notify(new ReservationApproved('Upload Deposit Slip'));
        }

        $message = "You have successfully updated the booking.";


        return response()->json([
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $sampleItem
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $item = Invoice::withTrashed()->findOrFail($id);
        $main = $item->book->guests->where('main', true)->first();
        $user = $item->user;
        
        if($item->is_paypal_payment) {
            $main->notify(new ReservationRejected);
            $user->notify(new ReservationRejected);
        } else {
            $main->notify(new ReservationRejected);
            $user->notify(new ReservationRejected);
        }

        $item->archive();

        return response()->json([
            'message' => "You have successfully archived {$item->renderName()}",
        ]);
    }

    /**
     * Reject the invoice if bank deposit.
     *
     * @param  \App\Invoice  $id
     * @return \Illuminate\Http\Response
     */
    public function depositSlipReject($id)
    {
        $item = Invoice::withTrashed()->findOrFail($id);
        $main = $item->book->guests->where('main', true)->first();
        $user = $item->user;
        
        $main->notify(new BankDepositUploadRejected($item));
        $user->notify(new BankDepositUploadRejected($item));

        $item->update([
            'deposit_slip_approve' => 2 
        ]);

        return response()->json([
            'message' => "You have successfully rejected the reservation",
        ]);
    }

    /**
     * Approved the invoice if bank deposit.
     *
     * @param  \App\Invoice  $id
     * @return \Illuminate\Http\Response
     */
    public function depositSlipApproved($id)
    {
        $item = Invoice::withTrashed()->findOrFail($id);
        $main = $item->book->guests->where('main', true)->first();
        $user = $item->user;
        
        $main->notify(new BankDepositUploadApprove($item));
        $user->notify(new BankDepositUploadApprove($item));

        $item->update([
            'deposit_slip_approve' => 1,
            'is_paid' => true 
        ]);

        return response()->json([
            'message' => "You have successfully approved the invoice",
        ]);
    }
}
