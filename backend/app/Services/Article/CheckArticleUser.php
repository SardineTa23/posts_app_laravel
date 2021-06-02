<?php

namespace App\Services\Article;

class CheckArticleUser
{
    public static function checkUser(int $user_id) :bool
    {
       if(auth()->id() === $user_id) {
           return true;
       } else {
           return false;
       }
    }
}
