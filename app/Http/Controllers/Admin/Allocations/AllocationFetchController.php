<?php

namespace App\Http\Controllers\Admin\Allocations;

use Illuminate\Http\Request;
use App\Extenders\Controllers\FetchController;

use App\Models\Destinations\Destination;
use App\Models\Allocations\Allocation;

class AllocationFetchController extends FetchController
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
            'destination' => $item->renderDestination(),
            'name' => $item->name,
            'description' => $item->description,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;

        $admin = auth()->guard('admin')->user();
        $destinations = Destination::all();
        
        if($admin->destination_id) {
            $destinations = Destination::where('id', $admin->destination_id)->get();
        }

        if ($id) {
        	$item = Allocation::withTrashed()->findOrFail($id);
        	$item->name = $item->name;
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

    	return response()->json([
    		'item' => $item,
    		'destinations' => $destinations,
    	]);
    }
}
