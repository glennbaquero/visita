<?php

namespace App\Models\Announcements;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;

class Announcement extends Model
{
	/**
	 * Relationship 
	 */
	
	public function destinations() 
	{
		return $this->belongsToMany(Destination::class, 'destination_announcements', 'destination_id', 'announcement_id')->withTrashed();
	}

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['title', 'description'])
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
        return route($prefix . '.announcements.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.announcements.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.announcements.restore', $this->id);
    }
}
