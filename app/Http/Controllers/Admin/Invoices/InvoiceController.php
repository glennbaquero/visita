<?php

namespace App\Http\Controllers\Admin\Invoices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Admin\Invoices\InvoiceFetchController;

use App\Exports\Invoices\InvoiceExport;

use DB;
use Excel;
use Carbon\Carbon;

use App\Models\Invoices\Invoice;
use App\Models\Destinations\Destination;
use App\Models\Emails\GeneratedEmail;

use App\Notifications\Admin\ReservationApproved;
use App\Notifications\Admin\MasungiReservationApproved;
use App\Notifications\Admin\ReservationRejected;
use App\Notifications\Admin\BankDepositUploadRejected;
use App\Notifications\Admin\BankDepositUploadApprove;
use App\Notifications\Masungi\ApprovedReservationThruBankDeposit;
use App\Notifications\Web\Paypal\UserInvoicePaid;
use App\Notifications\Masungi\FinalPaymentPaid;
use App\Notifications\Masungi\InitialPaymentPaid;

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
            if($item->is_approved && $item->is_sent_first_payment) {
                $item->update(['is_approved' => 1, 'is_sent_second_payment' => true ]);
            }
            $item->update(['is_approved' => 1, 'is_sent_first_payment' => true ]);
        DB::commit();

        $main = $item->book->guests->where('main', true)->first();
        // $user = $item->user;
        $approved_notification = GeneratedEmail::where('notification_type', 'Approved reservation')->first();

        if($item->is_paypal_payment) {
            if($item->bookable_type === 'App\Models\API\Masungi') {
                $main->notify(new MasungiReservationApproved('Payment thru Paypal', $item));
            } else {
                $main->notify(new ReservationApproved('Payment thru Paynamics', $approved_notification));
            }
            // $user->notify(new ReservationApproved('Payment thru Paynamics'));
        } else {
            if($item->bookable_type === 'App\Models\API\Masungi') {
                $main->notify(new MasungiReservationApproved('Payment thru bank deposit', $item, false));
            }
            // $user->notify(new ReservationApproved('Upload Deposit Slip'));
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
    public function archive(Request $request, $id)
    {
        $request->validate([
            'rejected_reason' => 'required'
        ]);
        DB::beginTransaction();

        $item = Invoice::withTrashed()->findOrFail($id);
        $item->update(['rejected_reason' => $request->rejected_reason]);
        $main = $item->book->guests->where('main', true)->first();
        // $user = $item->user;
        
        $rejected_notification = GeneratedEmail::where('notification_type', 'Rejected reservation')->first();

        if($item->is_paypal_payment) {
            $main->notify(new ReservationRejected($rejected_notification, $item));
            // $user->notify(new ReservationRejected);
        } else {
            $main->notify(new ReservationRejected($rejected_notification, $item));
            // $user->notify(new ReservationRejected);
        }

        $item->archive();
        DB::commit();

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
        $item->update(['rejected_reason' => $request->rejected_reason]);
        $main = $item->book->guests->where('main', true)->first();
        // $user = $item->user;
        
        $main->notify(new BankDepositUploadRejected($item));
        // $user->notify(new BankDepositUploadRejected($item));

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
        // $user = $item->user;
        
        $main->notify(new BankDepositUploadApprove($item));
        // $user->notify(new BankDepositUploadApprove($item));

        $item->update([
            'deposit_slip_approve' => 1,
            'is_paid' => true 
        ]);

        return response()->json([
            'message' => "You have successfully approved the invoice",
        ]);
    }

    public function reports()
    {
        $filterDestinations = [];
        $destinations = Destination::all();
        $admin = auth()->guard('admin')->user();
        $destinations = Destination::all();
        if($admin->destination_id) {
            $destinations = Destination::where('id', $admin->destination_id)->get();
        }
        
        foreach ($destinations as $destination) {
            array_push($filterDestinations, [
                'label' => $destination->name,
                'value' => $destination->id,
                'allocations' => $destination->getAllocationFilters()
            ]);
        }

        $filterCategories = [
            ['value' => 'paid', 'label' => 'Paid Reservation'],
            ['value' => 'unpaid', 'label' => 'Unpaid Reservation'],
            ['value' => 'forconformation', 'label' => 'For Confirmation'],
            ['value' => 'reject', 'label' => 'Rejected Reservation'],
            ['value' => 'all', 'label' => 'All'],
        ];

        $filterTypes = [
            ['value' => 'walkin', 'label' => 'Walk-In Reservation'],
            ['value' => 'online', 'label' => 'Online Reservation'],
            ['value' => 'all', 'label' => 'All'],
        ];

        return view('admin.exports.index', [
            'filterCategories' => json_encode($filterCategories),
            'filterTypes' => json_encode($filterTypes),
            'filterDestinations' => json_encode($filterDestinations)
        ]);
    }

    public function export(Request $request)
    {
        $controller = new InvoiceFetchController;

        $request = $request->merge(['nopagination' => 1]);

        $data = [];
        $data = $controller->fetch($request);

        $message = 'Exporting data, please wait...';

        if (!$data) {
            throw ValidationException::withMessages([
                'items' => 'No sample items found.',
            ]);
        }

        $file_name = 'Reservation_' . Carbon::parse($request->start_date)->format('M. d Y') . '.xls';
        if($request->end_date) {
            $file_name = 'Reservation_from_' . Carbon::parse($request->start_date)->format('M. d Y') . '_to_'.Carbon::parse($request->end_date)->format('M. d Y').'.xls';
        }
        if (!$request->ajax()) {
            $ids = Arr::pluck($data->original['items'], 'id');
            return Excel::download(new InvoiceExport($data->original['items']), $file_name);
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
            ]);
        }
    }

    public function initialPaid($id) {
        DB::beginTransaction();
            $invoice = Invoice::findOrFail($id);
            $invoice->update([
                'is_firstpayment_paid' => true
            ]);
        DB::commit();
        $main = $invoice->book->guests->where('main', true)->first();
        $main->notify(new InitialPaymentPaid($invoice));

        return response()->json([
            'paid' => true
        ]);
    }

    public function finalPaid($id) {
        DB::beginTransaction();
            $invoice = Invoice::findOrFail($id);
            $invoice->update([
                'is_secondpayment_paid' => true,
                'is_paid' => true
            ]);
        DB::commit();
        $main = $invoice->book->guests->where('main', true)->first();
        $main->notify(new UserInvoicePaid($invoice));
        $main->notify(new FinalPaymentPaid());

        return response()->json([
            'paid' => true
        ]);
    }

    public function fullFinalPaid($id) {
        DB::beginTransaction();
            $invoice = Invoice::findOrFail($id);
            $invoice->update([
                'is_firstpayment_paid' => true,
                'is_secondpayment_paid' => true,
                'is_paid' => true
            ]);
        DB::commit();
        $main = $invoice->book->guests->where('main', true)->first();
        $main->notify(new UserInvoicePaid($invoice));
        $main->notify(new FinalPaymentPaid());

        return response()->json([
            'paid' => true
        ]);
    }
}
