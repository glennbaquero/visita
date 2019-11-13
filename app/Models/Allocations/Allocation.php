<?php

namespace App\Models\Allocations;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Destinations\Destination;
use App\Models\Capacities\Capacity;
use App\Models\Fees\Fee;
use App\Models\Books\Book;

class Allocation extends Model
{
    /*
     * Relationships
     */
    
    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function agencyAllocations()
    {
    	return $this->hasMany(AgencyAllocation::class);
    }

    public function capacities()
    {
    	return $this->hasMany(Capacity::class);
    }

    public function fees()
    {
    	return $this->hasMany(Fee::class);
    }
}
