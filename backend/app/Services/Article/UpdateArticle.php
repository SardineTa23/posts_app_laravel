<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Services\Article\CheckArticleUser;

class UpdateArticle
{
    public static function update(array $validated, int $id)
    {
        if ($article = Article::find($id)) {
            if (CheckArticleUser::checkUser($article->user_id)) {
                $article->title = $validated['title'];
                $article->body = $validated['body'];
                $article->save();

                return $article;
            } else {
                abort(403);
            }
        } else {
            abort(404);
        }
    }
}
