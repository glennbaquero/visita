<?php

namespace App\Models\Allocations;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Agencies\Agency;

class AgencyAllocation extends Model
{
    /*
     * Relationships
     */
    
    public function allocation()
    {
    	return $this->belongsTo(Allocation::class)->withTrashed();
    }

    public function agency()
    {
    	return $this->belongsTo(Agency::class)->withTrashed();
    }
}
