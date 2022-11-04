<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
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

    public function show($id)
    {
        $response = Recipe::with('recipe_category')->where('id', $id)->first();
        return $this->apiSuccess($response);
    }
}
