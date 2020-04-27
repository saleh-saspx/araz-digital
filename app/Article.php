<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'body', 'image', 'base_url'
    ];
    public function User(){
        return $this->$this->hasOne(User::class,'id','user_id');
    }
    public function Category(){
        return $this->hasMany(ArticleHasCategory::class,'article_id','id')->with("Category");
    }
}
