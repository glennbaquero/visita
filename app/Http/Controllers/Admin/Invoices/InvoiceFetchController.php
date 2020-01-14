<?php

namespace App\Http\Controllers\Admin\Invoices;

use Illuminate\Http\Request;
use App\Extenders\Controllers\FetchController;

use App\Models\Invoices\Invoice;
use Carbon\Carbon;

class InvoiceFetchController extends FetchController
{
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
        return $result;
    }

    public function fetchView($id = null) {
        $item = null;

        if ($id) {
        	$item = Invoice::withTrashed()->findOrFail($id);
        	$item->guests = $this->getGuests($item->book);
            $item->is_paypal_payment = $item->is_paypal_payment ? true : false;
            $item->is_approved = $item->is_approved ? true : false;
        	$item->is_paid = $item->is_paid ? true : false;
        	$item->payment_type = $item->is_paypal_payment ? 'Paypal' : 'Bank Deposit';
        	$item->deposit_slip_show = $item->is_paypal_payment ? true : false;
        	$item->archiveUrl = $item->bank_deposit_slip && !$item->is_paypal_payment ? $item->renderRejectDepositSlipUrl() : $item->renderArchiveUrl();
            $item->renderDepositSlip = $item->bank_deposit_slip ? url('storage/'.$item->bank_deposit_slip) : null;
            $item->showImgTag = $item->bank_deposit_slip && !$item->is_paypal_payment ? true : false;
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

    	foreach ($book->guests as $guest) {

    		$type_daytourOrOvernight_fee = $is_daytour ? $guest->visitorType->daytour_fee : $guest->visitorType->overnight_fee;
    		$type_weekdayOrWeekend_fee = $is_weekday ? $guest->visitorType->weekday_fee : $guest->visitorType->weekend_fee;
    		$special_fee_weekdayOrWeekend = $guest->special_fee_id != null ? ($is_weekday ? $guest->specialFee->weekday_fee : $guest->specialFee->weekend_fee) : 0;
    		$special_fee_daytourOrOvernight = $guest->special_fee_id != null ? ($is_daytour ? $guest->specialFee->daytour : $guest->specialFee->overnight) : 0;

    		$total = $type_daytourOrOvernight_fee + $type_weekdayOrWeekend_fee - ($special_fee_weekdayOrWeekend + $special_fee_daytourOrOvernight);

    		array_push($result, [
    			'name' => $guest->renderFullname(),
    			'visitor_type_name' => $guest->visitorType->name,
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
