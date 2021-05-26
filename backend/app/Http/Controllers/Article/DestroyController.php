<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\Article\CheckArticleUser;
use App\Services\Article\DestroyArticle;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        DestroyArticle::destroy($id);
        return redirect('/');
    }
}
