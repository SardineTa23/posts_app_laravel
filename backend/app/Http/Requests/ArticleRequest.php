<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     Auth::check();
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route = $this->route()->getName();

        switch ($route) {
            case 'articles.store':
                $rules = [
                    'title' => ['required'],
                    'body' => ['required'],
                    'image1' => ['file', 'mimes:png,jpeg,gif,jpg'],
                    'image2' => ['file', 'mimes:png,jpeg,gif,jpg'],
                    'image3' => ['file', 'mimes:png,jpeg,gif,jpg']
                ];
                break;
            case 'articles.update': 
                $rules = [
                    'title' => ['required'],
                    'body' => ['required'],
                ];
                break;
        }
        
        return $rules;
    }
}
