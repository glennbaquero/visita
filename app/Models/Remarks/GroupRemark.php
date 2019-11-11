<?php

namespace App\Models\Remarks;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class GroupRemark extends Model
{
    public function book()
    {
    	return $this->belongsTo(Book::class);
    }
}
