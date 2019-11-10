<?php

namespace App\Models\Experiences;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;

class Experience extends Model
{
    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }
}
