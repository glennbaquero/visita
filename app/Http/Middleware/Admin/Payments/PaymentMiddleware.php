<?php

namespace App\Http\Middleware\Admin\Payments;

use App\Extenders\BaseMiddleware as Middleware;

class PaymentMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.payments.crud'];
    }
}
