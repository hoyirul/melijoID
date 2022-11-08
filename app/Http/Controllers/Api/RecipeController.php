<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRecipeRequest;
use App\Models\ProductRecipeRecomendation;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $response = Recipe::with('recipe_category')->get();
        return $this->apiSuccess($response);
    }

    public function search(SearchRecipeRequest $request)
    {
        $validated = $request->validated();
        $response = Recipe::with('recipe_category')
                     ->where('recipe_title', 'LIKE', '%'.$validated['recipe_title'].'%')
                     ->get();

        return $this->apiSuccess($response);
    }

    public function show_by_category($recipe_category_id)
    {
        $response = Recipe::with('recipe_category')
                    ->where('recipe_category_id', $recipe_category_id)->get();
                    
        return $this->apiSuccess($response);
    }

    public function show_category()
    {
        $response = RecipeCategory::all();
                    
        return $this->apiSuccess($response);
    }

    public function show($id)
    {
        $recipe = Recipe::with('recipe_category')->where('id', $id)->first();
        $recoms = ProductRecipeRecomendation::with('recipe')
                     ->where('recipe_id', $recipe->id)
                     ->get();
        $response = [
            'recipe' => $recipe,
            'recoms' => $recoms,
        ];
        return $this->apiSuccess($response);
    }
}
