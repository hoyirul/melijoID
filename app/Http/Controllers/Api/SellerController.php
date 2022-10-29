<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeaderTransaction;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\UserSeller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    use ApiResponse;

    public function index($ward){
        $response = UserSeller::join('users', 'users.id', '=', 'user_sellers.user_id')
                    ->join('user_addresses', 'user_addresses.user_id', '=', 'users.id')
                    ->join('addresses', 'user_addresses.addresses_id', '=', 'addresses.id')
                    ->where('addresses.ward', $ward)
                    ->get();
        return $this->apiSuccess($response);
    }

    public function show_by_id($id){
        $response = ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
                        ->where('products.user_seller_id', $id)
                        ->where('carousel', 1)
                        ->get();
        return $this->apiSuccess($response);
    }

    public function count_my_product_transaction($seller_id)
    {
        $product = Product::where('user_seller_id', $seller_id)->count();
        $trx = HeaderTransaction::where('user_seller_id', $seller_id)->count();
        $response = [
            'product_count' => $product,
            'transaction_count' => $trx
        ];
        return $this->apiSuccess($response);
    }
}

