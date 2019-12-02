<?php

namespace App\Models\Guests;

use App\Extenders\Models\BaseModel as Model;
use App\Traits\FileTrait;

use Illuminate\Notifications\Notifiable;
use App\Models\Types\VisitorType;
use App\Models\Books\Book;
use App\Models\Fees\Fee;

class Guest extends Model
{
   	use FileTrait, Notifiable;
	  
      protected $dates = ['birthdate'];
      
   	public function visitorType()
   	{
   		return $this->belongsTo(VisitorType::class);
   	}

   	public function book()
   	{
   		return $this->belongsTo(Book::class);
   	}

      public function specialFee() {
         return $this->belongsTo(Fee::class);
      }
}
