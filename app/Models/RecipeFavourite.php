<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeFavourite extends Model
{
    use HasFactory;

    protected $fillable = ['user_customer_id', 'recipe_id'];

    public function user_customer(){
        return $this->belongsTo(UserCustomer::class, 'user_customer_id', 'id');
    }

    public function recipe(){
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
