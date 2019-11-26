<?php

namespace App\Models\Capacities;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

class Capacity extends Model
{
    
    /*
     * Relationship
     */
    
	public function allocation()
	{
		return $this->belongsTo(Allocation::class);
	}

	/**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['allocation_id', 'online', 'walk_in', 'mgt_lgu', 'agency'])
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
	    return route($prefix . '.capacities.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.capacities.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.capacities.restore', $this->id);
	}

}
