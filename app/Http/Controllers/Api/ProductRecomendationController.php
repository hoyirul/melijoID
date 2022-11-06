<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRecipeRecomendation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductRecomendationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $response = ProductRecipeRecomendation::with('recipe')
                     ->get();
        return $this->apiSuccess($response);
    }

    public function show($id)
    {
        $recoms = ProductRecipeRecomendation::with('recipe')
                     ->where('id', $id)
                     ->first();
        $products = Product::where('product_name', 'LIKE', $recoms->keyword)
                    ->get();
        $response = [
            'recipe' => $recoms,
            'products' => $products
        ];
        return $this->apiSuccess($response);
    }
}
