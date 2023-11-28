<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model{
    // Tag -> table name = tags
    // customed table name;
    // protected $table = 'tags';
    protected $fillable = ['name', 'description'];
}