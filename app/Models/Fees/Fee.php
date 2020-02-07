<?php

namespace App\Models\Fees;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

class Fee extends Model
{
    public function allocation()
    {
    	return $this->belongsTo(Allocation::class)->withTrashed();
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['allocation_id', 'name', 'weekend', 'weekday', 'daytour', 'overnight'])
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

        return route($prefix . '.fees.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.fees.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.fees.restore', $this->id);
    }


    public function renderAllocation() {
        return $this->allocation->name;
    }

}
