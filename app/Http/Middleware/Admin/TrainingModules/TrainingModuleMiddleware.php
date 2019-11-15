<?php

namespace App\Http\Middleware\Admin\TrainingModules;

use App\Extenders\BaseMiddleware as Middleware;

class TrainingModuleMiddleware extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.training-modules.crud'];
    }
}
