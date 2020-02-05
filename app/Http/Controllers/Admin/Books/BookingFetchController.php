<?php

namespace App\Http\Controllers\Admin\Books;

use App\Extenders\Controllers\FetchController;

use App\Models\Books\Book;
use App\Models\Users\Management;
use Webpatser\Countries\Countries;
use App\Models\Fees\Fee;
use App\Models\Allocations\Allocation;
use App\Models\Types\VisitorType;
use App\Models\BlockedDates\BlockedDate;
use App\Models\Genders\Gender;

use Carbon\Carbon;

class BookingFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Book;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
    	if($this->request->destination) {
	    	$query = $query->where('destination_id', $this->request->destination);
    	}

    	if($this->request->experience) {
	    	$query = $query->where('allocation_id', $this->request->experience);
    	}
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
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        return [
            'id' => $item->id,
            'main_contact' => $this->getGuest($item->guests),
            'is_walkin' => $item->is_walkin === 1 ? 'Walk-In' : 'Online',
            'total_guest' => $item->total_guest,
            'allocation' => $item->allocation->name,
            'destination' => $item->destination->name,
            'grand_total' => 'P '.$item->invoice->grand_total,
            'balance' => 'P '.$item->invoice->balance,
            'is_fullpayment' => $item->invoice->is_fullpayment ? 'Full Payment' : 'Half Payment' ,
            'payment_status' => $item->invoice->renderPaymentStatusForMasungi() ,
            'time' => $item->start_time ? Carbon::createFromFormat('H:i:s', $item->start_time)->format('h:i A') : 'No visit time selected.',
            'status' => $item->ended_at != null ? 'Visit End ( '.$item->renderDate('ended_at').' )' : ($item->started_at == null ? 'Queue' : 'Started ( '.$item->renderDate('started_at').' )'),
            'qr_path' => $item->renderImagePath('qr_code_path'),
            'qr_id' => $item->qr_id,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    protected function sortQuery($query) {

        switch ($this->orderBy) {
            default:
                    $query = $query->orderBy($this->orderBy, 'desc');
                break;
        }

        return $query;
    }

    public function getGuest($guests)
    {
    	$result = [];

        foreach($guests as $guest) {
            if($guest->main === 1) {
            	$result['fullname'] = $guest->first_name.' '. $guest->last_name;
            	$result['email'] = $guest->email;
            	$result['contact_number'] = $guest->contact_number;
            	$result['type'] = $guest->visitorType ? $guest->visitorType->name : null;
                $result['deleted_at'] = $guest->deleted_at;
            }
        }

        return $result;
    }

    public function fetchView($id) {
        $item = null;

        if ($id) {
        	$item = Book::withTrashed()->findOrFail($id);
            $item->total_guests = $this->getGuests($item->guests()->where('main', false)->get());
            $main = $item->guests()->where('main', true)->first();
            $item->id = $main->id;
            $item->first_name = $main->first_name;
            $item->last_name = $main->last_name;
            $item->birthdate = $main->birthdate;
            $item->gender = $main->gender;
            $item->nationality = $main->nationality;
            $item->contact_number = $main->contact_number;
            $item->email = $main->email;
            $item->visitor_type_id = $main->visitor_type_id;
            $item->special_fee_id = $main->special_fee_id;
            $item->specialFeeImagePath = $main->renderImagePath('special_fee_path');
            $item->emergency_contact_number = $main->emergency_contact_number;
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }
        $destination = Destination::all();
        $experiences = Allocation::with('fees')->get();
        $nationalities = Countries::all();
        $visitor_types = VisitorType::all();
        $blocked_dates = $this->blockedDates($destination);
        $genders = Gender::all();

    	return response()->json([
    		'item' => $item,
            'managements' => Management::all(),
            'experiences' => $experiences,
            'nationalities' => $nationalities,
            'visitor_types' => $visitor_types,
            'blocked_dates' => $blocked_dates,
            'genders' => $genders
    	]);
    }

    public function blockedDates($destination) {
        $destination = Destination::find($destination);
        $items = $destination->blockedDates;

        $result = [];

        foreach($items as $item) {
            foreach ($item->dates as $date) {
                array_push($result, [
                    Carbon::parse($date->date)->toDateString()
                ]);
            }
        }

        return $result;
    }

    public function getGuests($items) {
        $data = [];

        foreach ($items as $item) {
            array_push($data, [
                'id' => $item->id,
                'first_name' => $item->first_name,
                'last_name' => $item->last_name,
                'birthdate' => $item->birthdate,
                'gender' => $item->gender,
                'nationality' => $item->nationality,
                'contact_number' => $item->contact_number,
                'email' => $item->email,
                'visitor_type_id' => $item->visitor_type_id,
                'special_fee_id' => $item->special_fee_id,
                'specialFeeImagePath' => $item->renderImagePath('special_fee_path'),
            ]);
        }

        return $data;
    }
}
