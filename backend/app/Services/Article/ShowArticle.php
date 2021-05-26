<?php

namespace App\Services\Article;


use App\Models\Article;
use App\Models\Image;




class ShowArticle
{
    public static function show(int $id,) 
    {
        if($article = Article::find($id)) {
            $thumbnail = Image::find($article->thumbnail_id);
            return ['article' => $article, 'thumbnail' => $thumbnail];
        } else {
            abort(404);
        }
    }
}
