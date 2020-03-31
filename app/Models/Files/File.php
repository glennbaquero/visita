<?php

namespace App\Models\Files;

use App\Extenders\Models\BaseModel as Model;

class File extends Model
{
    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/
	public function fileable()
	{
		return $this->morphTo();
	}
}
