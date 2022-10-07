<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_customer_id', 'user_seller_id', 'user_operator_id', 'date_order', 'total'];

    public function customer(){
        return $this->belongsTo(UserCustomer::class, 'user_customer_id', 'id');
    }

    public function seller(){
        return $this->belongsTo(UserSeller::class, 'user_seller_id', 'id');
    }

    public function operator(){
        return $this->belongsTo(UserOperator::class, 'user_operator_id', 'id');
    }
}
