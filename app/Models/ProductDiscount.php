<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'dicsount_id', 'start_date', 'end_date'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function descount(){
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
}
