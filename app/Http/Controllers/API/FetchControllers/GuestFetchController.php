<?php

namespace App\Http\Controllers\API\FetchControllers;

use App\Extenders\Controllers\FetchController;

use App\Models\Books\Book;

use Carbon\Carbon;

class GuestFetchController extends FetchController
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
    	$destination = auth()->guard('api')->user()->destination;
        $now = Carbon::now();
    	$query = $query->where('destination_id', $destination->id)->whereDate('scheduled_at', $now)->whereNotNull('ended_at');
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
            if($item->guests->where('main', true)->first()) {
                $data = $this->formatItem($item);
            }
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
        	'main_contact' => $item->guests->where('main', true)->first()->first_name. ' ' .$item->guests->where('main', true)->first()->last_name."'s Group" ,
        ];
    }
}
