<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    protected $fillable = [
        'key', 'value', 'expiration'
    ];
}
