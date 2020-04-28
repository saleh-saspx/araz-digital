<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title', 'slug', 'base_url'
    ];

    public function Content()
    {
        return $this->hasMany(ArticleHasCategory::class, 'category_id', 'id')->with('item');
    }
    public function getUrlAttribute()
    {
        return route('category.show', ['slug' => $this->attributes['slug']]);
    }
}
