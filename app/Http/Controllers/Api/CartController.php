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
        $response = Cart::select(['carts.id as cart_id', 'carts.product_id', 'carts.user_customer_id', 'carts.quantity', 'products.user_seller_id as user_seller_id', 'products.id as category_id', 'products.id as unit_id', 'products.product_name', 'products.price', 'products.stock', 'products.description', 'product_images.image', 'product_images.carousel', 'carts.grouping'])
                     ->join('products', 'products.id', '=', 'carts.product_id')
                     ->join('product_images', 'product_images.product_id', '=', 'products.id')
                     ->where('user_customer_id', $customer_id)
                     ->where('product_images.carousel', 1)
                     ->get();
        return $this->apiSuccess($response);
    }

    public function store(CartRequest $request)
    {
        $validated = $request->validated();
        
        $carts = Cart::where('product_id', $validated['product_id'])
                        ->where('user_customer_id', $validated['user_customer_id'])->first();

        if($carts != null){
            $qty = $validated['quantity'] + $carts->quantity;
            $response = Cart::where('id', $carts->id)->update([
                'product_id' => $validated['product_id'],
                'user_customer_id' => $validated['user_customer_id'],
                'quantity' => $qty,
                'grouping' => $validated['grouping'],
            ]);

            return $this->apiSuccess($response);
        }else{
            $response = Cart::create($request->all());
            return $this->apiSuccess($response);
        }
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
