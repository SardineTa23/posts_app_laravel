<?php

namespace App\Services\Article;
use App\Models\Article;

class EditArticle
{
    public static function edit(int $id) 
    {
        if($article = Article::find($id)) {
            if (CheckArticleUser::checkUser($article->user_id)) {
                return $article;
            } else {
                abort(403);
            }
        } else {
            abort(404);
        }
    }
}
