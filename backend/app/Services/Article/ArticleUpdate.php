<?php

namespace App\Services\Article;

use App\Models\Article;

class ArticleUpdate
{
    public static function update(Article $article, array $validated)
    {
        $article->title = $validated['title'];
        $article->body = $validated['body'];
        $article->save();
    }
}
