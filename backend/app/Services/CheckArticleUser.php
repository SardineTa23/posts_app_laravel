<?php

namespace App\Services;


class CheckArticleUser
{
    public static function checkUser(int $user_id)
    {
       if(auth()->id() === $user_id) {
           return true;
       } else {
           return false;
       }
    }
}
