<?php

namespace App\Http\Controllers\Admin\Invoices;

use Illuminate\Http\Request;
use App\Extenders\Controllers\FetchController;

use App\Models\Invoices\Invoice;
use App\Models\Books\Book;
use App\Models\Payments\Payment;
use Carbon\Carbon;

class InvoiceFetchController extends FetchController
{
    private $is_walkin;
	/**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Invoice;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {

        $this->is_walkin = $this->request->booking_type == 'walkin' ? true : false;

        if($this->request->filled('category') && $this->request->category != 'all' && $this->request->category != '') {
            if($this->request->category == 'paid') {
                $query = $query->where('is_paid', true);
            }

            if($this->request->category == 'unpaid') {
                $query = $query->where(['is_approved' => true, 'is_paid' => false]);   
            }

            if($this->request->category == 'forconformation') {
                $query = $query->where(['is_approved' => false, 'is_paid' => false]);   
            }

            if($this->request->category == 'reject') {
                $query = $query->withTrashed()->whereNotNull('deleted_at');   
            }
        } elseif ($this->request->filled('category') && $this->request->category == 'all' && $this->request->category != '') {
            $query = $query->withTrashed();
        }

        

        if($this->request->filled('booking_type') && $this->request->booking_type != 'all' && $this->request->booking_type != '') {
            $query = $query->whereHas('book', function($book) {
                $book->where(['destination_id' => $this->request->destination_id, 'allocation_id' => $this->request->allocation_id, 'is_walkin' => $this->is_walkin]);
            });
        } elseif ($this->request->filled('booking_type') && $this->request->booking_type == 'all' && $this->request->booking_type != '') {
            $query = $query->whereHas('book', function($book) {
                $book->where(['destination_id' => $this->request->destination_id, 'allocation_id' => $this->request->allocation_id]);
            });
        }

        $query = $query->where('created_at','>=',$this->request->start_date)->where('created_at','<=',$this->request->end_date);

        return $query;
    } 

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */
    public function formatData($items)
    {
        $result = [];
        foreach($items as $item) {
            $data = $this->formatItem($item);
            array_push($result, $data);
        }

        return $result;
    }

    /**
     * Build array data
     * 
     * @param  App\Models\Invoices\Invoice
     * @return array
     */
    protected function formatItem($item)
    {
        return [
            'id' => $item->id,
            'destination' => $item->book->destination ? $item->book->destination->name : '',
            'allocation' => $item->book->allocation->name,
            'main_contact' => $item->book->guests->where('main', true)->first()->renderFullname(),
            'email' => $item->book->guests->where('main', true)->first()->email,
            'contact_number' => $item->book->guests->where('main', true)->first()->contact_number,
            'emergency_contact_number' => $item->book->guests->where('main', true)->first()->emergency_contact_number,
            'total_guest' => $item->book->total_guest,
            'scheduled_at' => $item->book->scheduled_at->format('M d, Y') .' '. Carbon::createFromFormat('H:i:s', $item->book->start_time)->format('h:i A'),
            'conservation_fee' => $item->conservation_fee,
            'platform_fee' => $item->platform_fee,
            'transaction_fee' => $item->transaction_fee,
            'sub_total' => $item->sub_total,
            'grand_total' => $item->grand_total,
            'payment_type' => $item->book->from_masungi_reservation ? ($item->is_paypal_payment ? 'Paypal' : 'Bank Deposit') : 'Paynamics',
            'is_approved' => $item->is_approved ? 'Already Approved' : ($item->deleted_at ? 'Rejected' : 'For Confirmation'),
            'reference_code' => $item->reference_code,
            'is_paid' => $item->renderPaymentStatus(),
            'payment_method' => $item->is_fullpayment ? 'Fullpayment' : 'Half Payment',
            'amount_settled' => $item->amount_settled,
            'balance' => $item->balance,
            'reservation_from' => $item->book->from_masungi_reservation ? 'Masungi' : 'Visita',
            'created_at' => $item->renderDate(),
            'deleted_at' => $item->renderDate('deleted_at'),
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = Invoice::withTrashed()->findOrFail($id);
        	$item->guests = $this->getGuests($item->book);
            $item->payment_method = Payment::where('code', $item->paynamics_gateway_code)->first() ? Payment::where('code', $item->paynamics_gateway_code)->first()->renderImagePath() : 'images/paynamics.png';
            $item->is_paypal_payment = $item->is_paypal_payment ? true : false;
            $item->from_masungi_reservation = $item->book->from_masungi_reservation ? true : false;
            $item->reservation_from = $item->book->from_masungi_reservation ? 'Masungi Reservation' : 'Visita Reservation';
            $item->is_approved = $item->is_approved ? true : false;
        	$item->is_paid = $item->is_paid ? true : false;
            $item->payment_type = $item->is_paypal_payment ? 'Paypal' : 'Bank Deposit';
            $item->payment_settle = $item->is_fullpayment ? 'Full Payment' : 'Half Payment';
        	$item->btn_label = $item->is_sent_first_payment ? 'Resend billing' : 'Approved and send billing';
            if(!$item->is_fullpayment && !$item->is_firstpayment_paid && !$item->is_secondpayment_paid) {
                // if($item->is_sent_first_payment) {
                    if(!$item->is_sent_first_payment) {
                        $item->btn_label = 'Approved and send initial billing';
                    }  else {
                        $item->btn_label = 'Resend billing';
                    }
                // }
            } elseif (!$item->is_fullpayment && $item->is_firstpayment_paid && !$item->is_secondpayment_paid) {
                $item->btn_label = 'Send second billing';
            }
        	$item->deposit_slip_show = $item->is_paypal_payment ? true : false;
        	$item->archiveUrl = $item->bank_deposit_slip && !$item->is_paypal_payment ? $item->renderRejectDepositSlipUrl() : $item->renderArchiveUrl();
            $item->renderDepositSlip = $item->bank_deposit_slip ? url('storage/'.$item->bank_deposit_slip) : null;
            $item->showImgTag = $item->bank_deposit_slip && !$item->is_paypal_payment ? true : false;
            $item->updateInitialPaymentUrl = $item->renderInitialPaymentUrl();
            $item->updateFinalPaymentUrl = $item->renderFinalPaymentUrl();
            $item->updateFullFinalPaymentUrl = $item->renderFullFinalPaymentUrl();
            $item->showButtonForBankDeposit = $item->renderShowButtonTypeForBankDeposit();
        }

    	return response()->json([
    		'item' => $item,
    	]);
    }

    public function getGuests($book) {
    	$result = [];
    	$fee = 0;

    	$is_weekday = Carbon::parse($book->scheduled_at)->isWeekday();
    	$converted_time = strtotime($book->start_time);
    	$is_daytour = date('H', $converted_time) < 12 ?? false;
        $type_daytourOrOvernight_fee = 0;
        $type_weekdayOrWeekend_fee = 0;
        $special_fee_weekdayOrWeekend = 0;
        $special_fee_daytourOrOvernight = 0;
        $guests = $book->guests->where('main', false);

    	foreach ($guests as $guest) {
            if(!$book->from_masungi_reservation) {
                $type_daytourOrOvernight_fee = $is_daytour ? $guest->visitorType->daytour_fee : $guest->visitorType->overnight_fee;
                $type_weekdayOrWeekend_fee = $is_weekday ? $guest->visitorType->weekday_fee : $guest->visitorType->weekend_fee;
                $special_fee_weekdayOrWeekend = $guest->special_fee_id != null ? ($is_weekday ? $guest->specialFee->weekday : $guest->specialFee->weekend) : 0;
                $special_fee_daytourOrOvernight = $guest->special_fee_id != null ? ($is_daytour ? $guest->specialFee->daytour : $guest->specialFee->overnight) : 0;

            }

            $total = $type_daytourOrOvernight_fee + $type_weekdayOrWeekend_fee - ($special_fee_weekdayOrWeekend + $special_fee_daytourOrOvernight);
    		

    		array_push($result, [
    			'name' => $guest->renderFullname(),
    			'visitor_type_name' => $guest->visitorType ? $guest->visitorType->name : '---',
    			'type_daytourOrOvernight_fee' => $type_daytourOrOvernight_fee,
    			'type_weekdayOrWeekend_fee' => $type_weekdayOrWeekend_fee,
    			'special_fee_name' => $guest->special_fee_id != null ? $guest->specialFee->name : '---',
    			'special_fee_weekdayOrWeekend' => $special_fee_weekdayOrWeekend,
    			'special_fee_daytourOrOvernight' => $special_fee_daytourOrOvernight,
    			'total' => $total
    		]);
    	}

    	return $result;
    }
}
