<?php

namespace App\Models\TrainingModules;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;

class TrainingModule extends Model
{
    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }
}
