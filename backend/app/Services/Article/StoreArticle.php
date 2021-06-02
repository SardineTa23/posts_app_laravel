<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Services\Image\CreateImage;
use App\Services\ArticleTagRelationship\CreateArticleTagRelationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreArticle
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function create(ArticleRequest $request)
    {
        $this->check_log_in();
        $this->article->title = $request->input('title');
        $this->article->body = $request->input('body');
        $this->article->user_id = Auth::user()->id;
        $imgs = ['image2', 'image3'];
        DB::transaction(function () use ($request, $imgs) {
            $this->article->save();
            $this->create_image_and_tags($this->article, $request, $imgs);
        });

        return $this->article;
    }

    private function check_log_in()
    {
        if (Auth::user()) {
            return true;
        } else {
            abort(403);
        }
    }

    private function create_image_and_tags($article, $request, $imgs)
    {
        // サムネイル
        if ($request['image1']) {
            $file = $request['image1'];
            $article->thumbnail_id = CreateImage::create($file, $article->id);
            $article->save();
        }

        // その他の画像
        foreach ($imgs as $img) {
            if ($request[$img]) {
                $file = $request[$img];
                CreateImage::create($file, $article->id);
            }
        }

        // タグ
        if (!empty($request['tag_id'])) {
            foreach ($request['tag_id'] as $tag_id) {
                CreateArticleTagRelationship::create($tag_id, $article->id);
            }
        }
    }
}
