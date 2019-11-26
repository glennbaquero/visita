<?php

namespace App\Models\TrainingModules;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;

use App\Traits\FileTrait;
use Storage;

class TrainingModule extends Model
{
    use FileTrait;

    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }

    /**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['title', 'destination_id', 'description', 'type'])
	{
	    $vars = $request->only($columns);

	    $vars['type'] = $request->type ? 1 : 0;

	    if (!$item) {
	        $item = static::create($vars);
	    } else {
	        $item->update($vars);
	    }

	    if ($request->hasFile('path') && $item->type == 0) {
            $item->storeImage($request->file('path'), 'path', 'training_modules');
        } else {
        	$file = $request->file('path');
        	$filename = $file->getClientOriginalName();
        	$path = 'public/galleries-video';
        	$upload_path = Storage::putFileAs($path, $file, $filename);
        	$vars['path'] = $upload_path;
        	$item->path = $upload_path;
        	$item->save();
        }

	    return $item;
	}

	/**
	 * @Render
	 */
	public function renderShowUrl($prefix = 'admin') {
	    return route($prefix . '.training-modules.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.training-modules.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.training-modules.restore', $this->id);
	}

	public function getType() {
		$type = $this->type  === 0 ? 'Image' : 'Video';

		return $type;
	}
}
