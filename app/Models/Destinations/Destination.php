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
use App\Models\Managements\Management;
use App\Models\AddOns\AddOn;

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

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'code', 'icon', 'terms_conditions', 'visitor_policies', 'operating_hours', 'orientation_module', 'capacity_per_day', 'overview', 'contact_us', 'fees', 'how_to_get_here'])
    {
        $vars = $request->only($columns);

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
}
