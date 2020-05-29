<?php

namespace App\Http\Middleware\Admin\Genders;

use App\Extenders\BaseMiddleware as Middleware;

class GenderMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.genders.crud'];
    }
}
