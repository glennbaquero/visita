<?php

namespace App\Models\Answers;

use App\Extenders\Models\BaseModel as Model;

class Answer extends Model
{
    public function answerable()
    {
    	return $this->morphTo();
    }
}
