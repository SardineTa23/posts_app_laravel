<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\StoreArticle;

class StoreController extends Controller
{
    public function __invoke(ArticleRequest $request, StoreArticle $servise)
    {
        $article = $servise->create($request);
        return redirect()->route('articles.show', ['id' => $article->id]);
    }
}
