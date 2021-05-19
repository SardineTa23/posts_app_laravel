<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\CreateArticle;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        $thumbnail = Image::find($article->thumbnail_id);
        return view('articles.show', compact('article', 'thumbnail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
