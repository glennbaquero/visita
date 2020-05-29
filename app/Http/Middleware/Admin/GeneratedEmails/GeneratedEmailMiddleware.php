<?php

namespace App\Http\Middleware\Admin\GeneratedEmails;

use App\Extenders\BaseMiddleware as Middleware;

class GeneratedEmailMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.generated-emails.crud'];
    }
}
