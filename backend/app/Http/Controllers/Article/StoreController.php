<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\CreateArticle;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __invoke(ArticleRequest $request)
    {
        $validated = $request->validated();
        if (Auth::user() && strval(Auth::user()->id) === $validated['user_id']) {
            $article = CreateArticle::create($validated);
            return redirect()->route('articles.show', ['id' => $article->id]);
        } else {
            return redirect('/');
        }
    }
}
