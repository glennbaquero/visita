<?php

namespace App\Http\Controllers\Admin\Calendars;

use App\Extenders\Controllers\FetchController;

use App\Models\Books\Book;

class CalendarFetchController extends FetchController
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
        $i = 0;
        $bookings = Book::with('destination')->where('destination_id', $this->request->destination_id)->where('allocation_id', $this->request->allocation_id)->get()->sortBy('scheduled_at');
        $res = $bookings->groupBy(function ($result, $key) { 
            return $result->scheduled_at->format('Y-m-d'); 
        })->map(function ($result) {
	        return ($result); 
	    });



        foreach($res as $key => $item) {
    		foreach($res[$key] as $parsedKey => $parsedData) {
    			if(!collect($result)->contains('start', $key)) {
    				array_push($result, [
				        'start' => $key,
				        'title' => $parsedData->whereDate('scheduled_at', $key)->sum('total_guest').'/'.$parsedData->destination->capacity_per_day,
				        'color' => 'transparent',
				        'textColor' => 'black',
				        'fontSize' => '2em'
				    ]);		
    			}
        	}
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
            'events' => $item,
        ];
    }
}
