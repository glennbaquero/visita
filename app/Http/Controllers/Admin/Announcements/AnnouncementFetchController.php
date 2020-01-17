<?php

namespace App\Http\Controllers\Admin\Announcements;

use App\Extenders\Controllers\FetchController;

use App\Models\Announcements\Announcement;
use App\Models\Destinations\Destination;

class AnnouncementFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Announcement;
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
            'destination' => count($item->destinations) > 0 ? $item->destinations->pluck('name') : 'Sent to all',
            'title' => str_limit($item->title, 15),
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

        if ($id) {
        	$item = Announcement::withTrashed()->findOrFail($id);
        	$item->destination_ids = $item->destinations()->allRelatedIds();
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

        $destinations = Destination::all();

        if($admin->destination_id) {
            $destinations = Destination::where('id', $admin->destination_id)->get();
        }

    	return response()->json([
    		'item' => $item,
    		'destinations' => $destinations
    	]);
    }
}
