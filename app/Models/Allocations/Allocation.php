<?php

namespace App\Models\Allocations;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;
use App\Models\Capacities\Capacity;
use App\Models\Fees\Fee;
use App\Models\Books\Book;

class Allocation extends Model
{
    /*
     * Relationships
     */
    
    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function agencyAllocations()
    {
    	return $this->hasMany(AgencyAllocation::class);
    }

    public function capacities()
    {
    	return $this->hasMany(Capacity::class);
    }

    public function fees()
    {
    	return $this->hasMany(Fee::class);
    }


    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['destination_id', 'name', 'description'])
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

        return route($prefix . '.allocations.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.allocations.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.allocations.restore', $this->id);
    }


    public function renderDestination() {
        return $this->destination->name;
    }

}
