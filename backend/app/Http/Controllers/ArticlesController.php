<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|integer',
            'title' => ['required'],
            'body' => ['required'],
            'image1' => ['required', 'file', 'mimes:png,jpeg,gif,jpg'],
            'image2' => ['file', 'mimes:png,jpeg,gif,jpg'],
            'image3' => ['file', 'mimes:png,jpeg,gif,jpg'],
            'tag_id' => ['required']
        ];
        $this->validate($request, $rules);

        $article = CreateArticle::create($request);
        return redirect()->route('articles.show', ['article' => $article->id]);
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
        if ($article && CheckArticleUser::checkUser($article)) {
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
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        if ($article && CheckArticleUser::checkUser($article)) {
            $rules = [
                'user_id' => 'required|integer',
                'title' => ['required'],
                'body' => ['required'],
            ];
            $this->validate($request, $rules);
            $article->title = $request->title;
            $article->body = $article->body;
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
        if ($article && CheckArticleUser::checkUser($article)) {
            $article->delete();
            return redirect('/');
        } else {
            return redirect('/');
        }
    }
}
