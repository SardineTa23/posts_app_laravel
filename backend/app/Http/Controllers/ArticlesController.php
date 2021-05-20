<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ArticleRequest;
use App\Services\CreateArticle;
use App\Services\CheckArticleUser;



class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $article = new Article;
        $current_user = Auth::user();
        $tags = DB::table('tags')
            ->select('id', 'name')
            ->get();

        return view('articles.create', compact('article', 'tags', 'current_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($article = Article::find($id)) {
            $thumbnail = Image::find($article->thumbnail_id);
            return view('articles.show', compact('article', 'thumbnail'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
            return view('articles.edit', compact('article'));
        } else {
            return redirect("/");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $validated = $request->validated();
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article->user_id)) {
           
            $article->title = $validated['title'];
            $article->body = $validated['body'];
            $article->save();

            return redirect()->route('articles.show', ['article' => $article->id]);
        } else {
            return redirect("/");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
