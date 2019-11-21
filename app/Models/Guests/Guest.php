<?php

namespace App\Models\Guests;

use App\Extenders\Models\BaseModel as Model;

use Illuminate\Notifications\Notifiable;
use App\Models\Types\VisitorType;

class Guest extends Model
{
	use Notifiable;
	
   	public function visitorType()
   	{
   		return $this->belongsTo(VisitorType::class);
   	}

   	public function book()
   	{
   		return $this->belongsTo(Book::class);
   	}
}
