<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'txid';
    protected $fillable = ['txid', 'user_customer_id', 'user_seller_id', 'user_operator_id', 'promo_code', 'date_order', 'total', 'status'];
    public $incrementing = false;

    public function user_customer(){
        return $this->belongsTo(UserCustomer::class, 'user_customer_id', 'id');
    }

    public function user_seller(){
        return $this->belongsTo(UserSeller::class, 'user_seller_id', 'id');
    }

    public function user_operator(){
        return $this->belongsTo(UserOperator::class, 'user_operator_id', 'id');
    }

    public function promo(){
        return $this->belongsTo(Promo::class, 'promo_code', 'promo_code');
    }
}
