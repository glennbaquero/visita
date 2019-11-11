<?php

namespace App\Models\AddOns;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class AddOn extends Model
{
    /*
	 * Relationships
	 */
	
	public function book()
	{
		return $this->belongsTo(Book::class)
	}
}
