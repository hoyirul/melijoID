<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRecipeRecomendation extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'keyword', 'image'];

    public function recipe(){
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }
}
