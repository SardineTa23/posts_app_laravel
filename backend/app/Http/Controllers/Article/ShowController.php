<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Image;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        if ($article = Article::find($id)) {
            $thumbnail = Image::find($article->thumbnail_id);
            return view('articles.show', compact('article', 'thumbnail'));
        } else {
            return redirect('/');
        }
    }
}
