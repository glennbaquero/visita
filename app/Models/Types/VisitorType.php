<?php

namespace App\Models\Types;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Guests\Guest;

class VisitorType extends Model
{
    public function guests()
    {
    	return $this->hasMany(Guest::class);
    }
}
