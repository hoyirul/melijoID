<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFavourite extends Model
{
    use HasFactory;

    protected $fillable = ['user_customer_id', 'product_id'];

    public function customer(){
        return $this->belongsTo(UserCustomer::class, 'user_customer_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
