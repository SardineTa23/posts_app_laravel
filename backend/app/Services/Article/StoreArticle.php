<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Services\Image\CreateImage;
use App\Services\ArticleTagRelationship\CreateArticleTagRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class StoreArticle
{
    public static function create(array $formData)
    {
        if (Auth::user() && strval(Auth::user()->id) === $formData['user_id']) {
            $article = new Article($formData);
            $imgs = ['image2', 'image3'];
            DB::transaction(function () use ($article, $formData, $imgs) {
                $article->save();
                if (array_key_exists('image1', $formData)) {
                    $file = $formData['image1'];
                    $article->thumbnail_id = CreateImage::create($file, $article->id);
                    $article->save();
                }

                foreach ($imgs as $img) {
                    if (array_key_exists($img, $formData)) {
                        $file = $formData[$img];
                        CreateImage::create($file, $article->id);
                    }
                }

                foreach ($formData['tag_id'] as $tag_id) {
                    CreateArticleTagRelationship::create($tag_id, $article->id);
                }
            });

            return $article;
        } else {
            return abort(403);
        }
    }
}
