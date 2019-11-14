<?php

namespace App\Http\Middleware\Admin\AddOns;

use App\Extenders\BaseMiddleware as Middleware;

class AddOnMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.add_ons.crud'];
    }
}
