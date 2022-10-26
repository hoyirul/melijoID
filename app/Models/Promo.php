<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = [
        'promo_code', 'promo_title', 'promo_description', 'promo_end', 'promo_total'
    ];

    public function header_transaction(){
        $this->hasMany(HeaderTransaction::class);
    }
}
