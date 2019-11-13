<?php

namespace App\Models\Books;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Violations\GroupViolation;
use App\Models\Remarks\GroupRemark;
use App\Models\AddOns\AddOn;
use App\Models\Allocations\Allocation;
use App\Models\Destinations\Destination;
use App\Models\Guests\Guest;

class Book extends Model
{

    protected $dates = ['scheduled_at'];

	public function addOns()
	{
		return $this->hasMany(AddOn::class);
	}

    public function groupViolations() 
    {
    	return $this->hasMany(GroupViolation::class);
    }

    public function groupRemarks() 
    {
    	return $this->hasMany(GroupRemark::class);
    }

    public function allocation()
    {
        return $this->belongsTo(Allocation::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['allocation_id'], $destination_id)
    {
        // $vars = $request->only($columns);
        $vars['allocation_id'] = $request->allocation_id;
        $vars['total_guest'] = $request->total_guest;
        $vars['scheduled_at'] = $request->scheduled_at;
        $vars['re_scheduled_at'] = $request->scheduled_at;
        $vars['destination_id'] = $destination_id;
        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.bookings.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.bookings.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.bookings.restore', $this->id);
    }
}
