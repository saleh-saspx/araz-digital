<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleHasCategory extends Model
{
    protected $fillable = [
        'article_id', 'category_id'
    ];

    public function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function item()
    {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

}
