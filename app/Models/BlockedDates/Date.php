<?php

namespace App\Models\BlockedDates;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Date extends Model
{
	protected $guarded = [];

	protected $dates = ['date'];

	protected $appends = ['formattedDate'];

	public function getFormattedDateAttribute()
	{
		return Carbon::parse($this->date)->toDateTimeString();
	}

    public function blockedDate()
    {
    	return $this->belongsTo(BlockedDate::class)->withTrashed();
    }
}
