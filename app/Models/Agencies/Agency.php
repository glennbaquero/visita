<?php

namespace App\Models\Agencies;

use Illuminate\Database\Eloquent\Model;

use App\Models\Allocations\AgencyAllocation;

class Agency extends Model
{
    public function agencyAllocations()
    {
    	return $this->hasMany(AgencyAllocation::class);
    }
}
