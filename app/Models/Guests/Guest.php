<?php

namespace App\Models\Guests;

use App\Extenders\Models\BaseModel as Model;
use App\Traits\FileTrait;

use Illuminate\Notifications\Notifiable;
use App\Models\Types\VisitorType;
use App\Models\Books\Book;
use App\Models\Fees\Fee;

use DB;

class Guest extends Model
{
   	use FileTrait, Notifiable;
	  
    protected $dates = ['birthdate'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $searchable = [
            'id' => $this->id,
            'contact_number' => $this->contact_number,
            'emergency_contact_number' => $this->emergency_contact_number,
            'email' => $this->email,
            'nationality' => $this->nationality,
            'gender' => $this->gender,
            'special_fee' => $this->specialFee ? $this->specialFee->name : '',
        ];
        
        return $searchable;
    }

   	public function visitorType()
   	{
   		return $this->belongsTo(VisitorType::class)->withTrashed();
   	}

   	public function book()
   	{
   		return $this->belongsTo(Book::class)->withTrashed();
   	}

      public function specialFee() {
         return $this->belongsTo(Fee::class)->withTrashed();
      }

      public function scopeAgedBetween($query, $start, $end = null)
      {
          if (is_null($end)) {
              $end = $start;
          }

          $now = $this->freshTimestamp();
          $start = $now->subYears($start);
          $end = $now->subYears($end)->addYear()->subDay(); // plus 1 year minus a day

          return $this->whereBetween(DB::raw('TIMESTAMPDIFF(YEAR,birthdate,CURDATE())'), [$start, $end]);
      }

      public function renderFullname() 
      {
        return ucwords($this->first_name. ' '. $this->last_name);
      }

      public function renderName() {
        return ucwords($this->first_name . ' ' . $this->last_name);
    }
}
