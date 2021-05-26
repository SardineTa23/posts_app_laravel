<?php

namespace App\Services\Article;

use App\Models\Article;

class DestroyArticle
{
    public static function destroy($id) 
    {
        if ($article = Article::find($id)) {
            if (CheckArticleUser::checkUser($article->user_id)) {
                $article->delete();
            } else {
                abort(403);
            }
        } else {
            abort(404);
        }
    }
}
