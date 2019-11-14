<?php

namespace App\Models\Users;

use App\Extenders\Models\BaseUser as Authenticatable;
use App\Notifications\Web\Auth\VerifyEmail;
use Illuminate\Validation\ValidationException;
use Password;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\Frontliner\ResetPassword;

use Laravel\Scout\Searchable;

use App\Traits\FileTrait;
use App\Traits\HelperTrait;

use App\Models\Destinations\Destination;
use App\Models\Roles\Role;

class Management extends Authenticatable implements MustVerifyEmail, JWTSubject
{
	use FileTrait;
	use HelperTrait;
	use Searchable;

	protected $fillable = [
		'role_id', 'destination_id', 'first_name', 'last_name', 'email', 'username',
		'contact_number', 'password', 'status'
	];

	protected $appends = ['fullname'];

    public function role()
    {
    	return $this->belongsTo(Role::class);
    }

    public function destination()
    {
    	return $this->belongsTo(Destination::class);
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

	public function toSearchableArray()
	{
		return [
			'id' => $this->id,
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'destination' => $this->destination->name,
		];
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

	/**
	 * @Setters
	 */
	public static function store($request, $item = null, $columns = ['first_name', 'last_name', 'role_id', 'destination_id', 'email', 'username', 'contact_number'])
	{
	    $vars = $request->only($columns);

	    if (!$item) {
        	$vars['password'] = uniqid();
	        $item = static::create($vars);
			$broker = $item->broker();
			$broker->sendResetLink($request->only('email'));
            $item->sendEmailVerificationNotification();
	    } else {
	        $item->update($vars);
	    }

	    return $item;
	}

	/**
     * Overrides default reset password notification
     */
    
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new VerifyEmail);
    }

    public function broker() {
        return Password::broker('managements');
    }
    /**
	 * Appends fullname
	 * 
	 * @return string
	 */
	public function getFullnameAttribute()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * @Render
	 */
	public function renderShowUrl($prefix = 'admin') {
	    return route($prefix . '.managements.show', $this->id);
	}

	public function renderArchiveUrl($prefix = 'admin') {
	    return route($prefix . '.managements.archive', $this->id);
	}

	public function renderRestoreUrl($prefix = 'admin') {
	    return route($prefix . '.managements.restore', $this->id);
	}
}
