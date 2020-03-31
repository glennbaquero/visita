<?php

namespace App\Models\Pages;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\FileTrait;
use App\Traits\HelperTrait;

class Team extends Model
{
    use FileTrait, HelperTrait;


    const TYPE_TEAM = 0;
    const TYPE_COLLABORATORS = 1;
    const TYPE_ADVISOR = 2;

    /**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['type', 'name', 'designation', 'description'])
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
     * @Getters
     */
    public static function getTypes() {
        return [
            ['value' => static::TYPE_TEAM, 'label' => 'Team', 'class' => 'bg-info'],
            ['value' => static::TYPE_COLLABORATORS, 'label' => 'Collaborators', 'class' => 'bg-success'],
            ['value' => static::TYPE_ADVISOR, 'label' => 'Advisor', 'class' => 'bg-warning'],
        ];
    }

	/**
	 * @Render
	 */
	public function renderShowUrl($prefix = 'admin') {
	    return route($prefix . '.teams.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.teams.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.teams.restore', $this->id);
	}

	public function renderTypeLabel() {
        return $this->renderConstants(static::getTypes(), $this->type, 'label');
    }

    public function renderTypeClass() {
        return $this->renderConstants(static::getTypes(), $this->type, 'class');
    }
}
