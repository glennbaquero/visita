<?php

namespace App\Models\Books;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Violations\GroupViolation;
use App\Models\Remarks\GroupRemark;
use App\Models\AddOns\AddOn;

class Book extends Model
{

	public function addOns()
	{
		return $this->hasMany(AddOn::class);
	}

    public function groupViolations() 
    {
    	return $this->hasMany(GroupViolation::class);
    }

    public function groupRemarks() 
    {
    	return $this->hasMany(GroupRemark::class);
    }
}
