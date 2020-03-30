<?php

namespace App\Http\Controllers\Web\Articles;

use App\Extenders\Controllers\Articles\ArticleFetchController as Controller;

class ArticleFetchController extends Controller
{
	/**
     * Build array data
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        return [
        	'path' => $item->renderImagePath(),
            'showUrl' => $item->renderShowUrl('web'),
        ];
    }

    protected function formatView($item)
    {
        return $item;
    }
}
