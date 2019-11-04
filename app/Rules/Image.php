<?php

namespace App\Rules;

use App\Extenders\BaseRule as Rule;

class Image extends Rule
{
	protected $message = 'Please upload a valid image with maximum size of 2mb';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->rules = 'image|max:2048';
    }
}
