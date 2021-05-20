<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Tag;

class ArticleTagRelationship extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }
}
