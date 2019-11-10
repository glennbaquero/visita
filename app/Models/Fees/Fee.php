<?php

namespace App\Models\Fees;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Allocations\Allocation;

class Fee extends Model
{
    public function allocation()
    {
    	return $this->belongsTo(Allocation::class);
    }
}
