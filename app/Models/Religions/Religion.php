<?php

namespace App\Models\Religions;

use App\Extenders\Models\BaseModel as Model;

class Religion extends Model
{
    /**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['name'])
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
	    return route($prefix . '.religions.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.religions.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.religions.restore', $this->id);
	}
}
