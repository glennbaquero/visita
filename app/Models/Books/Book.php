<?php

namespace App\Models\Books;

use App\Extenders\Models\BaseModel as Model;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;

use App\Models\Violations\GroupViolation;
use App\Models\Remarks\GroupRemark;
use App\Models\AddOns\AddOn;
use App\Models\Allocations\Allocation;
use App\Models\Destinations\Destination;
use App\Models\Guests\Guest;
use App\Models\Feedbacks\GuestFeedback;
use App\Models\Invoices\Invoice;

use App\Traits\FileTrait;
use App\Models\Users\Management;

use Carbon\Carbon;

class Book extends Model
{

    use FileTrait, EloquentJoin;

    protected $dates = ['scheduled_at', 'ended_at', 'started_at'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $guests = $this->guests;
        $searchable = [
            'id' => $this->id,
            'destination' => $this->destination ? $this->destination->name : '',
            'allocation' => $this->allocation ? $this->allocation->name : '',
            // 'time' => $this->time,
            'total_guest' => $this->total_guest,
            'is_walkin' => $this->is_walkin == 1 ? 'Walk-In' : 'Online',
            'guest' => $guests,
            'status' => $this->getStatus(),
            'start_time' => str_replace(':','',Carbon::parse($this->start_time)->format('h:i A'))        
        ];
        
        return $searchable;
    }

    /**
     * Morph relationship to Management and User Models
     */
    public function bookable()
    {
        return $this->morphTo();
    }

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

    public function allocation()
    {
        return $this->belongsTo(Allocation::class)->withTrashed();
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class)->withTrashed();
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function guestFeedbacks() 
    {
        return $this->hasMany(GuestFeedback::class);
    }
    
    public function representative()
    {
        return $this->belongsTo(Management::class, 'destination_representative_id')->withTrashed();
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class)->withTrashed();
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['allocation_id'], $destination_id)
    {
        // $vars = $request->only($columns);
        $vars['allocation_id'] = $request->allocation_id;
        $vars['scheduled_at'] = $request->scheduled_at;
        $vars['start_time'] = $request->scheduled_at;
        $vars['re_scheduled_at'] = $request->scheduled_at;
        $vars['destination_id'] = $destination_id;
        $vars['total_guest'] = $request->total_guest;
        $vars['is_walkin'] = true;
        
        if (!$item) {
            // $item = static::create($vars);
            $item = auth()->user()->books()->create($vars);
        } else {
            $item->update($vars);
            $item->total_guest = $request->total_guest;
            $item->save();
        }

        return $item;
    }

    /**
     * @Render
     */
    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.bookings.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.bookings.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.bookings.restore', $this->id);
    }

    public static function generateRandomString($length = 15, $additionalString = null)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charLength = strlen($characters);

        $randomString = null;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charLength - 1)];
        }

        $randomString .= $additionalString;
        
        return 'VST'.$randomString;
    }

    public function renderName($first_column = 'first_name', $second_column = 'last_name') {
        return $this->guests->first();
    }

    public function getStatus() {
        $started = $this->started_at;
        $ended = $this->ended_at;
        $status = 'Queue';
        if($started != null && $ended == null) {
            $status = 'Ongoing';
        } 

        if($started != null && $ended != null) {
            $status = 'Finished';
        }

        return $status;
    }

    public function getGuests() {
        $result = [];

        foreach ($this->guests as $guest) {
            array_push($result, [
                'name' => $guest->renderFullname(),
                'email' => $guest->email,
                'main' => $guest->main ? true : false,
                'nationality' => $guest->nationality,
                'birthdate' => $guest->birthdate,
                'contact_number' => $guest->contact_number,
            ]);
        }

        return $result;
    }

    public function renderTime() {
        return Carbon::parse($this->scheduled_at)->format('g:i A');
    }
}
