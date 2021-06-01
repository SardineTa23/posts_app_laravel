<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArticleTagRelationship;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'App\Models\ArticleTagRelationship');
    }

    public function article_tag_relationships()
    {
        return $this->hasMany('App\Models\ArticleTagRelationship');
    }
}
