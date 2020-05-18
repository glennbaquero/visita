<?php

namespace App\Models\Experiences;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;
use App\Models\Times\TimeSlot;

class Experience extends Model
{
    protected $table = 'experiences';
    
    public function destination()
    {
    	return $this->belongsTo(Destination::class)->withTrashed();
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['destination_id', 'name', 'description', 'fee'])
    {
        $vars = $request->only($columns);

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
        $route = $this->id;

        if ($prefix == 'web') {
            $route = [$this->id, $this->slug];
        }

        return route($prefix . '.experiences.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.experiences.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.experiences.restore', $this->id);
    }


    public function renderDestination() {
        return $this->destination->name;
    }



}
