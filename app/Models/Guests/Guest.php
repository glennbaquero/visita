<?php

namespace App\Models\Guests;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Types\VisitorType;

class Guest extends Model
{
   	public function visitorType()
   	{
   		return $this->belongsTo(VisitorType::class);
   	}
}
