<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Services\CreateImage;
use App\Services\CreateArticleTagRelationship;
use Illuminate\Support\Facades\DB;


class CreateArticle
{
    public static function create(Request $request)
    {
        $article = new Article($request->all());
        $imgs = ['image2', 'image3'];
        DB::transaction(function () use ($article, $request, $imgs) {
            $article->save();
            if (!empty($request->image1)) {
                $file = $request->file('image1');
                $article->thumbnail_id = CreateImage::create($file, $article->id);
                $article->save();
                foreach ($imgs as $img) {
                    $file = $request->file($img);
                    if ($file) {
                        CreateImage::create($file, $article->id);
                    }
                }
    
                foreach ($request->tag_id as $tag_id) {
                    CreateArticleTagRelationship::create($tag_id, $article->id);
                }
            }
            
        });

        return $article;
    }
}
