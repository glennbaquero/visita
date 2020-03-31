<?php

namespace App\Models\Violations;

use App\Extenders\Models\BaseModel as Model;

class Violation extends Model
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
	    return route($prefix . '.violations.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.violations.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.violations.restore', $this->id);
	}
}
