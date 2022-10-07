<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['txid', 'invoice', 'evidence_of_transfer', 'paid_date', 'pay', 'status'];

    public function header_transaction(){
        return $this->belongsTo(HeaderTransaction::class, 'txid', 'txid');
    }
}
