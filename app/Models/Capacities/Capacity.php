<?php

namespace App\Models\Capacities;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

class Capacity extends Model
{
    
	public function allocation()
	{
		return $this->belongsTo(Allocation::class);
	}

}
