<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Models\ProductImage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = ProductImage::with('product')
                     ->get();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductImageRequest $request)
    {
        $validated = $request->validated();

        $validated['image'] = $request->file('image')->store('products/'.$validated['product_id'], 'public');

        $productImage = ProductImage::orderBy('carousel', 'DESC')->where('product_id', $validated['product_id'])->first();

        if((($productImage == null) ? 1 : $productImage->carousel) >= 3){
            $response = [
                'message' => 'Image cannot be more than 3!'
            ];
        }else{
            $response = ProductImage::create([
                'product_id' => $validated['product_id'],
                'image' => $validated['image'],
                'carousel' => ($productImage == null) ? 1 : $productImage->carousel + 1,
            ]);
        }

        return $this->apiSuccess($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = ProductImage::with('product')
                        ->where('id', $id)->first();
        return $this->apiSuccess($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(ProductImageRequest $request, $id)
    {
        $validated = $request->validated();
        $productImage = ProductImage::with('product')
                        ->where('id', $id)->first();
        if(file_exists(storage_path('app/public/'.$productImage->image))){
            Storage::delete(['public/', $productImage->image]);
        }

        $validated['image'] = $request->file('image')->store('product/'.$validated['product_id'], 'public');
        
        $response = ProductImage::where('id', $id)->update([
            'image' => $validated['image'],
        ]);

        ProductImage::where('id', $id)->update($request->all());
        $response = ProductImage::with('product')
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
        $response = ProductImage::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}