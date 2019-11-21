<?php

namespace App\Http\Middleware\Admin\Remarks;

use App\Extenders\BaseMiddleware as Middleware;

class RemarkMiddleware  extends Middleware
{
    public function __construct() {
        $this->permissions = ['admin.remarks.crud'];
    }
}
