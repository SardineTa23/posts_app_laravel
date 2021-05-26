<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateController extends Controller
{
    public function __invoke()
    {
        $article = new Article();
        $current_user = Auth::user();
        $tags = DB::table('tags')
            ->select('id', 'name')
            ->get();

        return view('articles.create', compact('article', 'tags', 'current_user'));
    }
}
