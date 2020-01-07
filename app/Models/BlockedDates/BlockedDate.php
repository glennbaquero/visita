<?php

namespace App\Models\BlockedDates;

use App\Extenders\Models\BaseModel as Model;
use App\Models\Destinations\Destination;

class BlockedDate extends Model
{

	protected $dates = ['date'];

    public function dates() 
    {
        return $this->hasMany(Date::class);
    }

    public function destination() 
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'mode', 'description', 'destination_id'])
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
        return route($prefix . '.blocked-dates.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.blocked-dates.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.blocked-dates.restore', $this->id);
    }
}
