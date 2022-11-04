<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_category_name'];

    public function recipe(){
        return $this->hasMany(Recipe::class);
    }
}
