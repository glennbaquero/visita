<?php

namespace App\Models\Capacities;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

class Capacity extends Model
{

	/**
	 * Get the indexable data array for the model.
	 *
	 * @return array
	 */
	public function toSearchableArray()
	{
	    $searchable = [
	        'id' => $this->id,
	        'online' => $this->online,
	        'walk_in' => $this->walk_in,
	        'mgt_lgu' => $this->mgt_lgu,
	        'agency' => $this->agency,
	        'allocation' => $this->allocation->name,
	    ];
	    
	    return $searchable;
	}
    
    /*
     * Relationship
     */
    
	public function allocation()
	{
		return $this->belongsTo(Allocation::class)->withTrashed();
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
