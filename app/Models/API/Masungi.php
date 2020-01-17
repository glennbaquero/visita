<?php

namespace App\Models\API;

use App\Extenders\Models\BaseUser as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Laravel\Scout\Searchable;

use App\Models\Books\Book;
use App\Models\Invoices\Invoice;

class Masungi extends Authenticatable implements JWTSubject
{

	/**
	 * Management can create many bookings
	 */
	public function books()
	{
		return $this->morphMany(Book::class, 'bookable');
	}

	public function invoices()
	{
		return $this->morphMany(Invoice::class, 'bookable');
	}

	
   	/**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
