<?php

namespace App\Models\Types;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Guests\Guest;

class VisitorType extends Model
{
	/*
	 * Relationship
	 */
    public function guests()
    {
    	return $this->hasMany(Guest::class);
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'weekend_fee', 'weekday_fee'])
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
        return route($prefix . '.visitor-types.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.visitor-types.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.visitor-types.restore', $this->id);
    }
}
