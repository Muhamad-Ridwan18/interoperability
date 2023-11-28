<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model{
    // Task -> table name = tasks
    // customed table name;
    // protected $table = 'tasks';
    protected $fillable = ['name','description','status','deadline','assigner','priority'];

    public $timestamps = true; //untuk melakukan update kolom created_at dan updated_at

}