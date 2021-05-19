<?php

namespace App\Services;

use App\Models\ArticleTagRelationship;
use App\Models\Tag;


class CreateArticleTagRelationship
{
    public static function create($tag_id, $article_id)
    {
        $tag = new ArticleTagRelationship();
        $tag->article_id = $article_id;
        $tag->tag_id = $tag_id;
        $tag->save();
    }
}
