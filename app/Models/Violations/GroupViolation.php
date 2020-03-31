<?php

namespace App\Models\Violations;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class GroupViolation extends Model
{
    public function book()
    {
    	return $this->belongsTo(Book::class)->withTrashed();
    }
}
