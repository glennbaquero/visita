<?php

namespace App\Models\Files;

use App\Extendables\BaseModel as Model;

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
