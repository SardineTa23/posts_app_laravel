<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Services\Article\EditArticle;


class EditController extends Controller
{
    public function __invoke($id)
    {
        $article = EditArticle::edit($id);
        return view('articles.edit', compact('article'));
    }
}
