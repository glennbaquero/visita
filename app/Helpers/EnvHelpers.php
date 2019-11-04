<?php

namespace App\Helpers;

use Auth;

class EnvHelpers
{
	public static function isDev() {
		return config('app.env') === 'local';
	}

	public function dev() {
		return static::isDev();
	}
}