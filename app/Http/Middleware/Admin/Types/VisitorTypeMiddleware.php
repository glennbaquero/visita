<?php

namespace App\Http\Middleware\Admin\Types;

use App\Extenders\BaseMiddleware as Middleware;

class VisitorTypeMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.visitor_types.crud'];
    }
}
