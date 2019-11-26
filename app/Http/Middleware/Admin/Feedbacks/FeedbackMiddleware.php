<?php

namespace App\Http\Middleware\Admin\Feedbacks;

use App\Extenders\BaseMiddleware as Middleware;

class FeedbackMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.feedbacks.crud'];
    }
}
