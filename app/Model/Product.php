<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Review;
class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name' , 'detail' , 'stock' , 'price' , 'discount'];

    public function reviews()
    {
        return $this->hasMany('App\Model\Review', 'product_id' , 'id');
    }
    
}
