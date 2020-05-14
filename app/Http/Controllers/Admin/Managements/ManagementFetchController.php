<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Extenders\Controllers\FetchController;

use App\Models\Users\Management;
use App\Models\Destinations\Destination;
use App\Models\Roles\Role;

class ManagementFetchController extends FetchController
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Management;
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
            'fullname' => $item->fullname,
            'email' => $item->email,
            'verified_at' => $item->renderDate('email_verified_at'),
            'destination' => $item->destination->name,
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
        	$item = Management::withTrashed()->findOrFail($id);
            $item->archiveUrl = $item->renderArchiveUrl();
            $item->restoreUrl = $item->renderRestoreUrl();
        }

        $roles = Role::whereIn('name', ['Frontliner', 'Destination Representative'])->get();

    	return response()->json([
    		'item' => $item,
    		'roles' => $roles,
    		'destinations' => $destinations
    	]);
    }
}
