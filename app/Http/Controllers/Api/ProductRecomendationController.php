<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductRecipeRecomendation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductRecomendationController extends Controller
{
    use ApiResponse;

    public function index($recipe_id)
    {
        $response = ProductRecipeRecomendation::with('recipe')
                     ->where('recipe_id', $recipe_id)
                     ->get();
        return $this->apiSuccess($response);
    }

    public function show($id, $seller_id)
    {
        $recoms = ProductRecipeRecomendation::with('recipe')
                     ->where('id', $id)
                     ->first();
        $products = ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
                     ->where('products.user_seller_id', $seller_id)
                     ->where('product_name', 'LIKE', '%'.$recoms->keyword.'%')
                     ->where('carousel', 1)
                     ->get();
        $response = [
            'recipe' => $recoms,
            'products' => $products
        ];
        return $this->apiSuccess($response);
    }
}
