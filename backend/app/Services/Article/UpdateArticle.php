<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Services\Article\CheckArticleUser;

class UpdateArticle
{
    public static function update(array $validated, int $id)
    {
        $article = self::check_find_article($id);

        if (CheckArticleUser::checkUser($article->user_id)) {
            $article->title = $validated['title'];
            $article->body = $validated['body'];
            $article->save();

            return $article;
        } else {
            abort(403);
        }
    }

    public static function check_find_article($id): Article
    {
        if ($article = Article::find($id)) {
            return $article;
        } else {
            abort(404);
        }
    }
}
