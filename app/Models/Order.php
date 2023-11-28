<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    // Order -> table name = orders
    // customed table name;
    // protected $table = 'orders';
    protected $fillable = ['customer_id','name','description','date','shipping_address','status'];

    public $timestamps = true; //untuk melakukan update kolom created_at dan updated_at

}