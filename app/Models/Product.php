<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    // Post -> table name = posts
    // customed table name;
    // protected $table = 'posts';
    protected $fillable = ['name','description','category_id','brand','price','stock'];

    public $timestamps = true; //untuk melakukan update kolom created_at dan updated_at

}