<?php

namespace App\Http\Middleware\Admin\Fees;

use App\Extenders\BaseMiddleware as Middleware;

class FeesMiddleware extends Middleware
{
     public function __construct() {
        $this->permissions = ['admin.special_fees.crud'];
    }
}
