<?php

namespace App\Http\Controllers\API\FetchControllers;

use App\Extenders\Controllers\FetchController;

use App\Models\Types\VisitorType;

class VisitorTypeFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new VisitorType;
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
            'name' => $item->name,
            'weekend_fee' => $item->weekend_fee,
            'weekday_fee' => $item->weekday_fee,
            'daytour_fee' => $item->daytour_fee,
            'overnight_fee' => $item->overnight_fee,
        ];
    }
}
