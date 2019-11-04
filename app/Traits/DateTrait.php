<?php

namespace App\Traits;

use App\Helpers\ObjectHelpers;

trait DateTrait 
{
    public function renderDate($column = 'created_at') {
        $date = null;

        if (isset($this->$column) && $this->$column) {
            $date = $this->$column->format('M d, Y (H:i:s)');
        }

        return $date;
    }
}