<?php

namespace App\Http\Controllers\API\FetchControllers;

use App\Extenders\Controllers\FetchController;

use App\Models\Allocations\Allocation;

class ExperienceFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Allocation;
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
    	$query = $query->where('destination_id', $destination->id);
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
            if($item->capacities()->exists()) {
                $data = $this->formatItem($item);
                array_push($result, $data);
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
        	'id' => $item->id,
            'name' => $item->name,
            'capacity' => $item->capacities->first()->walk_in,
            'desstination_capacity' => $item->destination->capacity_per_day,
            'platform_fee' => $item->platform_fees,
            'special_fees' => $item->fees,
            'timeslots' => $item->getTimeSlot(),
        ];
    }
}
