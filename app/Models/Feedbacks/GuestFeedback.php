<?php

namespace App\Models\Feedbacks;

use App\Extenders\Models\BaseModel as Model;

use App\Models\Books\Book;

class GuestFeedback extends Model
{

	protected $casts = [
    	'feedback_data' => 'array'
    ];
    
    public function book()
    {
    	return $this->belongsTo(Book::class);
    }

}
