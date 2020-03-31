<?php

namespace App\Models\AddOns;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;
use App\Models\Destinations\Destination;

class AddOn extends Model
{
    /*
	 * Relationships
	 */
	
	public function book()
	{
		return $this->belongsTo(Book::class)->withTrashed();
	}

	public function destinations()
	{
		return $this->belongsToMany(Destination::class, 'destination_add_ons', 'destination_id', 'add_on_id');
	}

	/**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['name', 'amount'])
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
	    return route($prefix . '.add-ons.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.add-ons.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.add-ons.restore', $this->id);
	}
}
