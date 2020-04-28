<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'body', 'image', 'base_url'
    ];

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function Category()
    {
        return $this->hasMany(ArticleHasCategory::class, 'article_id', 'id')->with("Category");
    }

    public function getContentAttribute()
    {
        return mb_substr(strip_tags($this->attributes['body']), 0, 300) . '...';
    }

    public function getUrlAttribute()
    {
        return route('article.show', ['slug' => $this->attributes['slug']]);
    }

    public function getJalaliCreatedAtAttribute()
    {
        return jdate($this->attributes['created_at'])->format('%B %d، %Y');
    }

}
