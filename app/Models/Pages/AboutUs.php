<?php

namespace App\Models\Pages;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\FileTrait;

class AboutUs extends Model
{
    use FileTrait;

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

	    if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'about_us');
        }

	    return $item;
	}

	/**
	 * @Render
	 */
	public function renderShowUrl($prefix = 'admin') {
	    return route($prefix . '.about-us.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.about-us.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.about-us.restore', $this->id);
	}
}
