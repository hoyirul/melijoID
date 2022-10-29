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
        $response = Recipe::all();
        return $this->apiSuccess($response);
    }

    public function show($id)
    {
        $response = Recipe::where('id', $id)->first();
        return $this->apiSuccess($response);
    }
}
