<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    // Category -> table name = categories
    // customed table name;
    // protected $table = 'categories';
    protected $fillable = ['name','description'];
}