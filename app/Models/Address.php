<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['province', 'city', 'districts', 'ward'];

    public function user_address(){
        return $this->hasMany(UserAddress::class);
    }
}
