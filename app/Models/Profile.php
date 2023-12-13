<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{

     protected $fillable = [
         'user_id',
         'first_name',
         'last_name',
         'summary',
         'image'
     ];

     public $timestamp = true;

     public function user() : Returntype {
          return $this->belongsTo(User::class);
     }
}