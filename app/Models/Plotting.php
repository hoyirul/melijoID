<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plotting extends Model
{
    use HasFactory;

    protected $fillable = ['user_customer_id', 'user_seller_id'];

    public function user_seller(){
        return $this->belongsTo(UserSeller::class, 'user_seller_id', 'id');
    }

    public function user_customer(){
        return $this->belongsTo(UserCustomer::class, 'user_customer_id', 'id');
    }
}
