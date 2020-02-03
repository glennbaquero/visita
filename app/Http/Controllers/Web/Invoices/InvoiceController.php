<?php

namespace App\Http\Controllers\Web\Invoices;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\Reservation\BookingNotification;
use App\Notifications\Web\Bookings\NewBookingNotification;
use App\Notifications\Reservation\BankDepositSlipUploadedNotification;

use App\Models\Invoices\Invoice;
use App\Models\Books\Book;
use App\Models\Users\Admin;

use App\Ecommerce\PaynamicsProcessor;

use DB;
use Storage;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
    	$guests = json_decode($request->guests);
        $admins = Admin::all();

    	DB::beginTransaction();

	    	$book = auth()->user()->books()->create([
	    		'start_time' => $request->start_time,
	    		'allocation_id' => $request->allocation_id,
	    		'destination_id' => $request->destination_id,
	    		'scheduled_at' => $request->scheduled_at,
	    		'total_guest' => $request->total_guest,
	    		'agency_code' => $request->agency_code,
                'is_walkin' => false
	    	]);

	    	foreach ($guests as $key => $guest) {
                $upload_path = null;
                if($request->file('special_fee_path')[$key] != null || $request->file('special_fee_path')[$key] != '') {
                    $file = $request['special_fee_path'][$key];
                    $filename = $file->getClientOriginalName();
                    $path = 'public/special_fee';
                    $upload_path = Storage::putFileAs($path, $file, $filename);
                }

	    		$book->guests()->create([
	    			'visitor_type_id' => $guest->visitor_type_id,
	    			'special_fee_id' => $guest->special_fee_id != 0 ?? null,
	    			'main' => $guest->main,
	    			'first_name' => $guest->first_name,
	    			'last_name' => $guest->last_name,
	    			'nationality' => $guest->nationality,
	    			'gender' => $guest->gender,
	    			'emergency_contact_number' => $guest->emergency_contact_number,
	    			'contact_number' => $guest->contact_number,
	    			'email' => $guest->email,
	    			'birthdate' => $guest->birthdate,
                    'special_fee_path' => $upload_path
	    		]);
	    	}

	    	auth()->user()->invoices()->create([
                // 'user_id' => auth()->user()->id,
	    		'book_id' => $book->id,
	    		'conservation_fee' => $request->conservation_fee,
	    		'platform_fee' => $request->platform_fee,
	    		'transaction_fee' => $request->transaction_fee,
	    		'sub_total' => $request->sub_total,
	    		'grand_total' => $request->grand_total,
	    		'is_paypal_payment' => $request->is_paypal_payment,
	    		'reference_code' => $request->grand_total.$this->generateReferenceCode().'VST'
	    	]);

	    	$main = $book->guests->where('main', true)->first();
            // $main->notify(new BookingNotification($book));

    	DB::commit();
        $admins = Admin::all();
    	// foreach ($admins as $admin) {
        //    $admin->notify(new NewBookingNotification($book->destination, $book->allocation, $book, $main));
        // }

    	return response()->json([
    		'success' => true
    	]);
    }

    public function generateReferenceCode() 
    {
    	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
	    return substr(str_shuffle($str_result),  
	                       0, 20);
    }

    public function show() 
    {
    	$result = [];
    	$invoices = auth()->user()->invoices;

    	foreach ($invoices as $invoice) {
    		array_push($result, [
    			'destination' => $invoice->book->destination->name,
    			'scheduled_at' => $invoice->book->scheduled_at->format('m/d/Y'),
    			'total_guest' => $invoice->book->total_guest,
    			'status_label' => $invoice->renderStatusLabel(),
    			'status_class' => $invoice->renderStatusClass(),
    			'total' => $invoice->grand_total,
    			'is_paid' => $invoice->is_paid ? true : false,
    			'is_approved' => $invoice->is_approved ? true : false,
    			'is_paypal_payment' => $invoice->is_paypal_payment ? true : false,
    			'reference_code' => $invoice->reference_code,
    			'id' => $invoice->id,
    			'showImgTag' => $invoice->bank_deposit_slip ?? false,
    			'deposit_slip' => !$invoice->is_paypal_payment ? url('storage/'.$invoice->bank_deposit_slip) : null
    		]);
    	}

    	return response()->json([
    		'items' => $result
    	]);
    }

    public function uploadDepositSlip(Request $request)
    {
    	$request->validate([
            'bank_deposit_slip' => 'required|mimes:jpeg,bmp,png'
        ]);
		$invoice = Invoice::find($request->id);
        $admins = Admin::all();
        $main = $invoice->book->guests->where('main', true)->first();

    	DB::beginTransaction();
    		$image = $request->file('bank_deposit_slip')->store('deposit-slip', 'public');
    		$invoice->update([
    			'bank_deposit_slip' => $image
    		]);


            // foreach ($admins as $admin) {
            //    $admin->notify(new BankDepositSlipUploadedNotification($invoice, $main));
            // }
    	DB::commit();


    	return response()->json([
    		'message' => 200
    	]);
    }

    /**
    * Generate Paynamics form
    *
    * @param object $invoice
    * @return string $form
    */
    public function generatePaynamicsForm(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $paynamics = new PaynamicsProcessor();
        $signature = $paynamics->createXML($invoice);

        /** Create form */
        $form = '<html><head><style>.lds-dual-ring {display: inline-block;width: 64px;height: 64px;} .lds-dual-ring:after {content: " ";display: block;width:46px;height: 46px;margin: 1px;border-radius: 50%;border: 5px solid red;border-color: red transparent red transparent;animation: lds-dual-ring 1.2s linear infinite;} @keyframes lds-dual-ring { 0% { transform: rotate(0deg); } 100% {transform: rotate(360deg);}} .centered { position: fixed;top: 50%;left: 50%;margin-top: -50px;margin-left: -20px; }</style></head><body onload="submitForm()"><div class="centered"><div class="lds-dual-ring"></div></div><form id="paynamicsForm" name="form1" method="post" action="'. config('ecommerce.paynamics.gateway') .'">'.
            '<input type="hidden" name="paymentrequest" id="paymentrequest" value="'. $signature  .'" style="width:800px; padding: 10px;">'.
            '</form><script type="text/javascript">function submitForm() { document.getElementById("paynamicsForm").submit(); }</script></body></html>';

        return response()->json([
            'form' => $form
        ]);
    }

    /**
     * Processing paynamics
     * 
     * @param  Requests $request 
     */
    public function processPaynamics(Request $request)
    {
        $processor = new PaynamicsProcessor();

        /** Process Paynamics */
        return $processor->process($request);
    }

    /**
     * Paynamics success return
     * 
     */
    public function paynamicsReturn(Request $request)
    {
        $processor = new PaynamicsProcessor();
        $route = $processor->processReturnResponse($request);

        return response()->json([

        ]);
    }

    /**
     * Paynamics cancel
     * 
     */
    public function paynamicsCancel()
    {
        return response()->json([

        ]);
    }
}
