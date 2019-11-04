<?php

namespace App\Http\Controllers\Web\Articles;

use App\Extenders\Controllers\Articles\ArticleController as Controller;

class ArticleController extends Controller
{
    protected $indexView = 'web.articles.index';
    protected $showView = 'web.articles.show';
    protected $guard = 'web';
}
