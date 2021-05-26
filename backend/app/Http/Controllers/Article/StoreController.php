<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\StoreArticle;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(ArticleRequest $request)
    {
        $validated = $request->validated();
        $article = StoreArticle::create($validated);
        return redirect()->route('articles.show', ['id' => $article->id]);
    }
}
