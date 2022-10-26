<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Product::with('user_seller')
                     ->with('category')
                     ->with('unit')
                     ->get();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try{
            $request->validated();
            $response = Product::create($request->all());

            return $this->apiSuccess($response);
        }catch(Exception $e){
            return response()->json([
                'message' => $e,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('user_seller')
                        ->with('category')
                        ->with('unit')
                        ->where('id', $id)->first();
        $productImage = ProductImage::where('product_id', $id)->get();
        
        $response = [
            'product' => $product,
            'images' => $productImage
        ];

        return $this->apiSuccess($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $request->validated();
        Product::where('id', $id)->update($request->all());
        $response = Product::with('user_seller')
                     ->with('category')
                     ->with('unit')
                        ->where('id', $id)->first();
        return $this->apiSuccess($response);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = Product::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
