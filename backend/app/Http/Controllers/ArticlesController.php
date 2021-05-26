<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\ArticleUpdate;
use App\Services\Article\CreateArticle;
use App\Services\Article\CheckArticleUser;



class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $article = new Article;
        $current_user = Auth::user();
        $tags = DB::table('tags')
            ->select('id', 'name')
            ->get();

        return view('articles.create', compact('article', 'tags', 'current_user'));
    }

    public function store(ArticleRequest $request)
    {
        $validated = $request->validated();
        if (Auth::user() && strval(Auth::user()->id) === $validated['user_id']) {
            $article = CreateArticle::create($validated);
            return redirect()->route('articles.show', ['article' => $article->id]);
        } else {
            return redirect('/');
        }
    }

    public function show($id)
    {
        if ($article = Article::find($id)) {
            $thumbnail = Image::find($article->thumbnail_id);
            return view('articles.show', compact('article', 'thumbnail'));
        } else {
            return redirect('/');
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
            return view('articles.edit', compact('article'));
        } else {
            return redirect("/");
        }
    }

    public function update(ArticleRequest $request, $id)
    {
        $validated = $request->validated();
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
           
            ArticleUpdate::update($article, $validated);
            return redirect()->route('articles.show', ['article' => $article->id]);
        } else {
            return redirect("/");
        }
    }

    public function destroy($id)
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
