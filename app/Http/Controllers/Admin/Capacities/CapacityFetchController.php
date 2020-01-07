<?php

namespace App\Http\Controllers\Admin\Capacities;

use App\Extenders\Controllers\FetchController;

use App\Models\Capacities\Capacity;
use App\Models\Allocations\Allocation;

class CapacityFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Capacity;
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

        $admin = auth()->guard('admin')->user();

        foreach($items as $item) {

            if($admin->getRoleNames()[0] === 'Destination Manager') {
                if($item->allocation->destination_id === $admin->destination_id) {
                    array_push($result, [
                        'id' => $item->id,
                        'allocation' => $item->allocation->name,
                        'online' => $item->online,
                        'mgt_lgu' => $item->mgt_lgu,
                        'walk_in' => $item->walk_in,
                        'agency' => $item->agency,
                        'total' => $item->agency + $item->walk_in + $item->mgt_lgu + $item->online,
                        'created_at' => $item->renderDate(),
                        'showUrl' => $item->renderShowUrl(),
                        'archiveUrl' => $item->renderArchiveUrl(),
                        'restoreUrl' => $item->renderRestoreUrl(),
                        'deleted_at' => $item->deleted_at,
                    ]);
                }
            } else {
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
            'allocation' => $item->allocation->name,
            'online' => $item->online,
            'mgt_lgu' => $item->mgt_lgu,
            'walk_in' => $item->walk_in,
            'agency' => $item->agency,
            'total' => $item->agency + $item->walk_in + $item->mgt_lgu + $item->online,
            'created_at' => $item->renderDate(),
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
            'deleted_at' => $item->deleted_at,
        ];
    }

    public function fetchView($id = null) {
        $item = null;
        $ids = collect(Capacity::all())->pluck('allocation_id');
        $admin = auth()->guard('admin')->user();
        $allocations = Allocation::with('destination')->whereNotIn('id', $ids)->get();
        
        if($admin->destination_id) {
            $allocations = Allocation::where('destination_id', $admin->destination_id)->with('destination')->whereNotIn('id', $ids)->get();
        }


        if ($id) {
        	$item = Capacity::withTrashed()->findOrFail($id);
        	$allocations = Allocation::with('destination')->whereNotIn('id', $ids)->orWhere('id', $item->allocation_id)->get();
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }


    	return response()->json([
    		'item' => $item,
    		'allocations' => $allocations
    	]);
    }
}
