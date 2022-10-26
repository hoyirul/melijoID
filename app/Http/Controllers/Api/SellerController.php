<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        $response = Product::with('unit')->with('category')->with('user_seller')
                    ->where('user_seller_id', $id)
                    ->get();
        return $this->apiSuccess($response);
    }
}

