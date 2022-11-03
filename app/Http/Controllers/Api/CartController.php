<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    public function index($customer_id)
    {
        // ProductImage::join('products', 'product_images.product_id', '=', 'products.id')
        //                 ->where('products.user_seller_id', $id)
        //                 ->where('carousel', 1)
        //                 ->get();
        $response = Cart::with('user_customer')
                     ->join('products', 'products.id', '=', 'carts.product_id')
                     ->join('product_images', 'product_images.product_id', '=', 'products.id')
                     ->where('user_customer_id', $customer_id)
                     ->where('product_images.carousel', 1)
                     ->get();
        return $this->apiSuccess($response);
    }

    public function store(CartRequest $request)
    {
        $request->validated();
        $response = Cart::create($request->all());

        return $this->apiSuccess($response);
    }

    public function show($id)
    {
        $response = Cart::with('product')->with('user_customer')
                        ->where('id', $id)->first();
        return $this->apiSuccess($response);
    }

    public function update(CartRequest $request, $id)
    {
        $request->validated();
        Cart::where('id', $id)->update($request->all());
        $response = Cart::with('user_customer')->with('product')
                        ->where('id', $id)->first();
        return $this->apiSuccess($response);
        
    }

    public function destroy($id)
    {
        $response = Cart::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
