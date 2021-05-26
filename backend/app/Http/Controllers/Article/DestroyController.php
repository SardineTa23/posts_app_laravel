<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\Article\CheckArticleUser;


class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
            $article->delete();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
