<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'App\Models\ArticleTagRelationship');
    }

    public function article_tag_relationships()
    {
        return $this->hasMany('App\Models\ArticleTagRelationship');
    }
}
