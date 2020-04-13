<?php

namespace App\Models\Users;

use App\Extenders\Models\BaseUser as Authenticatable;
use App\Models\Books\Book;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\Web\Auth\ResetPassword;
use App\Notifications\Web\Auth\VerifyEmail;
use Password;

use App\Models\Invoices\Invoice;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    /**
     * Overrides default reset password notification
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    /* Overrides default verification notification */
    public function sendEmailVerificationNotification() {
        $this->notify(new VerifyEmail);
    }

    public function device_tokens() {
        return $this->morphMany(DeviceToken::class, 'user');
    }

    public function providers() {
        return $this->morphMany(SocialiteProvider::class, 'user');
    }

    public function invoices() {
        return $this->morphMany(Invoice::class, 'bookable')->withTrashed();
    }

    /**
	 * Web Users can create many bookings
	 */
	public function books()
	{
		return $this->morphMany(Book::class, 'bookable');
	}

    /* Overrides default forgot password */
    public function broker() {
        return Password::broker('users');
    }

    /**
     * JWT Configurations
     */
    public function getJWTCustomClaims(): array {
        return [
            'guard' => 'web',
        ];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }


    /**
     * @Renders
     */
    
    /* User Verification Status */
    public function renderStatus($showLabel = true) {
        $result = $showLabel ? 'Unverified' : 'bg-danger';

        if ($this->email_verified_at) {
            $result = $showLabel ? 'Verified' : 'bg-success';
        }

        return $result;
    }

    public function renderShowUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return route($prefix . '.profiles.show');
        }
        
        return route($prefix . '.users.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.restore', $this->id);
    }
}