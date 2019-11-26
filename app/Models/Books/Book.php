<?php

namespace App\Models\Books;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Violations\GroupViolation;
use App\Models\Remarks\GroupRemark;
use App\Models\AddOns\AddOn;
use App\Models\Allocations\Allocation;
use App\Models\Destinations\Destination;
use App\Models\Guests\Guest;
use App\Models\Feedbacks\GuestFeedback;

use App\Traits\FileTrait;
use App\Models\Users\Management;

class Book extends Model
{

    use FileTrait;

    /**
     * Morph relationship to Management and User Models
     */
    public function bookable()
    {
        return $this->morphTo();
    }

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

    public function guestFeedbacks() 
    {
        return $this->hasMany(GuestFeedback::class);
    }
    
    public function representative()
    {
        return $this->belongsTo(Management::class, 'destination_representative_id');
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['allocation_id'], $destination_id)
    {
        // $vars = $request->only($columns);
        $vars['allocation_id'] = $request->allocation_id;
        $vars['scheduled_at'] = $request->scheduled_at;
        $vars['re_scheduled_at'] = $request->scheduled_at;
        $vars['destination_id'] = $destination_id;
        $vars['total_guest'] = $request->total_guest;
        $vars['is_walkin'] = true;
        if (!$item) {
            // $item = static::create($vars);
            $item = auth()->user()->books()->create($vars);
        } else {
            $item->update($vars);
            $item->total_guest += $request->total_guest;
            $item->save();
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

    public static function generateRandomString($length = 15, $additionalString = null)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($characters);

        $randomString = null;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }

        $randomString .= $additionalString;
        
        return 'VST'.$randomString;
    }
}
