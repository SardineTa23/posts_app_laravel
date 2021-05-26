<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Services\Article\CheckArticleUser;
use App\Services\Article\UpdateArticle;

class UpdateController extends Controller
{
    public function __invoke(ArticleRequest $request, $id)
    {
        $validated = $request->validated();
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
       
            UpdateArticle::update($article, $validated);
            return redirect()->route('articles.show', ['id' => $article->id]);
        } else {
            return redirect("/");
        }
    }
}
