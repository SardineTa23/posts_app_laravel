<?php

namespace App\Services;

use App\Models\Article;
use App\Services\CreateImage;
use App\Services\CreateArticleTagRelationship;
use Illuminate\Support\Facades\DB;


class CreateArticle
{
    public static function create(array $formData)
    {
        $article = new Article($formData);
        $imgs = ['image2', 'image3'];
        DB::transaction(function () use ($article, $formData, $imgs) {
            $article->save();
            if (!array_key_exists('image1', $formData)) {
                $file = $formData['image1'];
                $article->thumbnail_id = CreateImage::create($file, $article->id);
                $article->save();
            }

            foreach ($imgs as $img) {
                if (!array_key_exists($img, $formData)) {
                    $file = $formData[$img];
                    CreateImage::create($file, $article->id);
                }
            }

            foreach ($formData['tag_id'] as $tag_id) {
                CreateArticleTagRelationship::create($tag_id, $article->id);
            }
        });

        return $article;
    }
}
