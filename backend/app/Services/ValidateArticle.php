<?php

namespace App\Services;

use App\Http\Controllers\ArticlesController;
use App\Models\Article;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;

class ValidateArticle
{
    public static function validate(ArticlesController $articlesController, Request $request, string $method)
    {
        if ($method === 'create') {
            $rules = [
                'user_id' => 'required|integer',
                'title' => ['required'],
                'body' => ['required'],
                'image1' => ['required', 'file', 'mimes:png,jpeg,gif,jpg'],
                'image2' => ['file', 'mimes:png,jpeg,gif,jpg'],
                'image3' => ['file', 'mimes:png,jpeg,gif,jpg'],
                'tag_id' => ['required']
            ];
        } elseif ($method === 'update') {
            $rules = [
                'user_id' => 'required|integer',
                'title' => ['required'],
                'body' => ['required'],
            ];
        }

        $articlesController->validate($request, $rules);
    }
}
