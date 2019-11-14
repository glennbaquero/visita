<?php

namespace App\Http\Controllers\Admin\Books;

use App\Extenders\Controllers\FetchController;

use App\Models\Books\Book;
use App\Models\Users\Management;
use App\Models\Destinations\Destination;
use Webpatser\Countries\Countries;
use App\Models\Fees\Fee;
use App\Models\Allocations\Allocation;
use App\Models\Types\VisitorType;
use App\Models\BlockedDates\BlockedDate;

use Carbon\Carbon;

class BookFetchController extends FetchController
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
        $date = request()->segments()[3]; 
    	$parsedDate = Carbon::parse($date)->toDateTimeString();
        return $query->whereDate('scheduled_at', $parsedDate);
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
            'main_contact' => $this->getGuests($item->guests),
            'total_guest' => $item->total_guest,
            'allocation' => $item->allocation->name,
            'time' => Carbon::parse($item->scheduled_at)->toTimeString(),
            'status' => $item->status,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function getGuests($guests)
    {
    	$result = [];

        foreach($guests as $guest) {
            if($guest->main === 1) {
            	$result['fullname'] = $guest->first_name.' '. $guest->last_name;
            	$result['email'] = $guest->email;
            	$result['contact_number'] = $guest->contact_number;
            	$result['type'] = $guest->visitorType->name;
            }
        }

        return $result;
    }

    public function fetchView($id = 0, $destination = null, $experience = null) {
        $item = null;

        if ($id != 0) {
        	$item = Book::withTrashed()->findOrFail($id);
            $item->total_guests = $item->guests->where('main', false);
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
            $item->emergency_contact_number = $main->emergency_contact_number;
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

        $experiences = Destination::find($destination)->allocations;
        $nationalities = Countries::all();
        $special_fees = Allocation::find($experience)->fees;
        $visitor_types = VisitorType::all();
        $blocked_dates = $this->blockedDates();

    	return response()->json([
    		'item' => $item,
            'managements' => Management::all(),
            'experiences' => $experiences,
            'nationalities' => $nationalities,
            'special_fees' => $special_fees,
            'visitor_types' => $visitor_types,
            'blocked_dates' => $blocked_dates
    	]);
    }

    public function blockedDates() {
        $items = BlockedDate::all();

        $result = [];

        foreach($items as $item) {
            array_push($result, [
                Carbon::parse($item->date)->toDateString()
            ]);
        }

        return $result;
    }
}
