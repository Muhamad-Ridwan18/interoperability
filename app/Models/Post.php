<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    protected $fillable = ['title','author','category','status','content','user_id', 'image', 'video'];

    public $timestamps = true; //untuk melakukan update kolom created_at dan updated_at
}