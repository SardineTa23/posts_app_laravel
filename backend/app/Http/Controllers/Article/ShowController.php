<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Services\Article\ShowArticle;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $result = ShowArticle::show($id);
        $article = $result['article'];
        $thumbnail = $result['thumbnail'];
        return view('articles.show', compact('article', 'thumbnail'));
    }
}
