<?php

namespace App\Models\Users;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;
use App\Models\Roles\Role;

class Management extends Model
{
    public function role()
    {
    	return $this->belongsTo(Role::class);
    }

    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }
}
