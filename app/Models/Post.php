<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    // Post -> table name = posts
    // customed table name;
    // protected $table = 'posts';
    protected $fillable = ['title','author','category','status','content','user_id'];

    public $timestamps = true; //untuk melakukan update kolom created_at dan updated_at
}