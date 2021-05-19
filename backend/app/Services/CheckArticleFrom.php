<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class CheckArticleFrom
{
    public static function checkFromData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|max:255',
            'body' => 'required',
            'image' => 'required|file|image|mimes:png,jpeg,gif,jpg',
        ]);

        dd($validator);

        // if ($validator->fails()) {
        //     return redirect('/errorpage')
        //         ->withErrors($validator)
        //         ->withInput();
        // }
    }
}
