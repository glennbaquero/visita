<?php

namespace App\Http\Controllers\Admin\BlockedDates;

use App\Extenders\Controllers\FetchController;

use App\Models\BlockedDates\BlockedDate;
use App\Models\Destinations\Destination;

use Carbon\Carbon;

class BlockedDateFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new BlockedDate;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        $admin = auth()->guard('admin')->user();
        if($admin->destination_id) {
            $query = $query->where('destination_id', $admin->destination_id);
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
            foreach ($item->dates as $key => $date) {
                // $data = $this->formatItem($item);
                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'destination' => $item->destination->name,
                    'date' => $date->date->format('F d, Y'),
                    'created_at' => $item->renderDate(),
                    'showUrl' => $item->renderShowUrl(),
                    'archiveUrl' => $item->renderArchiveUrl(),
                    'restoreUrl' => $item->renderRestoreUrl(),
                    'deleted_at' => $item->deleted_at,
                ]);
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
            'date' => $item->date->format('F d, Y'),
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;
        $dates = [];
        
        $destinations = Destination::all();
        $admin = auth()->guard('admin')->user();
        if($admin->destination_id) {
            $destinations = Destination::where('id', $admin->destination_id)->get();
        }

        if ($id) {
        	$item = BlockedDate::withTrashed()->findOrFail($id);
            
            foreach ($item->dates as $key => $date) {
                array_push($dates, [
                    Carbon::parse($date->date)->toDateTimeString()
                ]);
            }

            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

    	return response()->json([
    		'item' => $item,
            'destinations' => $destinations,
            'dates' => collect($dates)->flatten()
    	]);
    }
}
