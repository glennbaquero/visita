<?php

namespace App\Http\Middleware\Admin\AnnualIncomes;

use App\Extenders\BaseMiddleware as Middleware;

class AnnualIncomeMiddleware extends Middleware
{
     public function __construct() {
        $this->permissions = ['admin.annual_incomes.crud'];
    }
}
