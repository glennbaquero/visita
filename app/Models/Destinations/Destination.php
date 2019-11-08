<?php

namespace App\Models\Destinations;

use App\Extenders\Models\BaseModel as Model;
use App\Traits\FileTrait;

use App\Models\Files\File;
use App\Traits\ManyImagesTrait;

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

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'code', 'terms_conditions', 'visitor_policies', 'operating_hours', 'orientation_module', 'capacity_per_day'])
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
    
    public function renderRemoveImageUrl($prefix = 'admin') {
        return route($prefix . '.destinations.remove-image', $this->id);
    }
}
