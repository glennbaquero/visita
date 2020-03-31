<?php

namespace App\Traits;

use App\Helpers\ObjectHelpers;

trait DateTrait 
{
    public function renderDate($column = 'created_at', $format="F d, Y (H:i:s)") {
        $date = null;

        if (isset($this->$column) && $this->$column) {
            $date = $this->$column->format($format);
        }

        return $date;
    }
}