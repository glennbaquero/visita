<?php

namespace App\Models\Destinations;

use App\Extenders\Models\BaseModel as Model;
use App\Traits\FileTrait;
use App\Traits\ManyImagesTrait;

use App\Models\Files\File;
use App\Models\Picture;
use App\Models\Allocations\Allocation;
use App\Models\Experiences\Experience;
use App\Models\TrainingModules\TrainingModule;
use App\Models\Users\Management;
use App\Models\AddOns\AddOn;
use App\Models\Books\Book;
use App\Models\Announcements\Announcement;
use App\Models\Users\Admin;
use App\Models\BlockedDates\BlockedDate;

use Carbon\Carbon;

class Destination extends Model
{

    use FileTrait, ManyImagesTrait;

	/*
	 * Relationships
	 */

	public function files()
	{
	    return $this->morphMany(File::class, 'fileable');
	}

	public function pictures()
	{
	    return $this->morphMany(Picture::class, 'parent');
	}

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function trainingModules()
    {
        return $this->hasMany(TrainingModule::class);
    }

    public function managements()
    {
        return $this->hasMany(Management::class);
    }

    public function addOns()
    {
        return $this->belongsToMany(AddOn::class, 'destination_add_ons', 'add_on_id', 'destination_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function announcements()
    {
        return $this->belongsToMany(Announcement::class, 'destination_announcements', 'announcement_id', 'destination_id');
    }

    public function admins() 
    {
        return $this->hasMany(Admin::class);
    }

    public function blockedDates()
    {
        return $this->hasMany(BlockedDate::class);
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'code', 'icon', 'terms_conditions', 'visitor_policies', 'operating_hours', 'operating_hours_end', 'orientation_module', 'capacity_per_day', 'overview', 'contact_us', 'fees', 'how_to_get_here', 'location', 'recommended', 'duration'])
    {
        $vars = $request->only($columns);
        $vars['is_available'] = $request->is_available ? 1: 0;

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('images')) {
            $item->addImages($request->file('images'));
        }

        return $item;
    }

    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        $route = $this->id;

        if ($prefix == 'web') {
            $route = [$this->id, $this->slug];
        }

        return route($prefix . '.destinations.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.destinations.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.destinations.restore', $this->id);
    }

    public function renderRemoveImageUrl($prefix = 'admin') {
        return route($prefix . '.destinations.remove-image', $this->id);
    }

    public function renderRequestVisitUrl() {
        return route('web.request-to-visit', [$this->id, $this->name]);
    }

    public function getFormattedData() {
        $result = [];

        foreach ($this->allocations as $key => $allocation) {
            if($allocation->capacities()->exists()) {
                array_push($result, [
                    'image' => $this->pictures->first()->renderImagePath(),
                    'allocation_name' => $allocation->name,
                    'allocation_id' => $allocation->id,
                    'allocation_capacity' => $allocation->capacities->first(),
                    'platform_fee' => $allocation->platform_fees,
                    'transaction_fee' => $allocation->transaction_fees,
                    'transaction_fee' => $allocation->transaction_fees,
                    'fee_per_head' => $allocation->fee_per_head,
                    'special_fees' => $allocation->fees,
                    'timeslot' => $allocation->getTimeSlot(),
                ]);
            }
        }

        return $result;
    }

    public function getBlockedDates() {
        $items = $this->blockedDates;

        $result = [];

        foreach($items as $item) {
            foreach ($item->dates as $date) {
                array_push($result, [
                    Carbon::parse($date->date)->toDateString()
                ]);
            }
        }
        return collect($result)->flatten();
    }

    public function getAllocationFilters() {
        $filterAllocations = [];

        foreach ($this->allocations as $allocation) {
            array_push($filterAllocations, [
                'label' => $allocation->name,
                'value' => $allocation->id,
            ]);
        }

        return $filterAllocations;
    }

    public function renderShortOverview()
    {
        if($this->overview) {
            $result = strip_tags($this->overview);
            return str_limit($result, 200);
        }        

    }

}
