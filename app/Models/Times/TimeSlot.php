<?php

namespace App\Models\Times;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

use Carbon\Carbon;

class TimeSlot extends Model
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
            'experience' => $this->allocation ? $this->allocation->name : '',
            'time' => $this->renderTime(),
        ];
        
        return $searchable;
    }

    
    public function allocation() 
    {
    	return $this->belongsTo(Allocation::class)->withTrashed();
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['allocation_id', 'time'])
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
        return route($prefix . '.time-slots.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.time-slots.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.time-slots.restore', $this->id);
    }

    public function renderTime() {
        return Carbon::parse($this->time)->format('g:i A');
    }
}
