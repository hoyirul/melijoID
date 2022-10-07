<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'total_dicount', 'description'];

    public function product_discount(){
        return $this->hasMany(ProductDiscount::class);
    }
}
