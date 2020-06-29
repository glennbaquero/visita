<?php

namespace App\Http\Controllers\Admin\Fees;

use Illuminate\Http\Request;
use App\Extenders\Controllers\FetchController;

use App\Models\Fees\Fee;
use App\Models\Allocations\Allocation;

class FeesFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Fee;
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
            $experiences = $admin->destination->allocations->pluck('id');
            $query = $query->whereIn('allocation_id', $experiences);
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
            'allocation' => $item->allocation->name,
            'name' => $item->name,
            'weekend' => $item->weekend,
            'weekday' => $item->weekday,
            'daytour' => $item->daytour,
            'overnight' => $item->overnight,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;
        $allocations = Allocation::all();

        if ($id) {
        	$item = Fee::withTrashed()->findOrFail($id);
        	$item->name = $item->name;
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

    	return response()->json([
    		'item' => $item,
    		'allocations' => $allocations,
    	]);
    }
}
