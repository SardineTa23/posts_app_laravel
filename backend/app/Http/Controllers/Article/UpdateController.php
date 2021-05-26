<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\UpdateArticle;

class UpdateController extends Controller
{
    public function __invoke(ArticleRequest $request, $id)
    {
        $validated = $request->validated();
        $article = UpdateArticle::update($validated, $id);
        return redirect()->route('articles.show', ['id' => $article->id]);
    }
}
