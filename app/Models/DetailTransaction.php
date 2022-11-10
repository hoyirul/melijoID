<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['txid', 'product_id', 'quantity', 'price', 'subtotal', 'information'];

    public function header_transaction(){
        return $this->belongsTo(HeaderTransaction::class, 'txid', 'txid');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
