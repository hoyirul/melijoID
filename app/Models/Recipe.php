<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_title', 'recipe_level', 'step', 'image'];

    public function recipe_favourite(){
        return $this->hasMany(RecipeFavourite::class);
    }
}
