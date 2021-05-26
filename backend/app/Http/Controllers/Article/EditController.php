<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\Article\CheckArticleUser;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke($id)
    {
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
            return view('articles.edit', compact('article'));
        } else {
            return redirect("/");
        }
    }
}
