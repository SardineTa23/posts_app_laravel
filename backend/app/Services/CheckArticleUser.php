<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Article;


class CheckArticleUser
{
    public static function checkUser(Article $article)
    {
       if(auth()->id() === $article->user_id) {
           return true;
       } else {
           return false;
       }
    }
}
