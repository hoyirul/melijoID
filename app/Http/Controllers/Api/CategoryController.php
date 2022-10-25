<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponse;
use Exception;

class CategoryController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Category::with('product')
                     ->get();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        try{
            $request->validated();
            $response = Category::create($request->all());

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
        $response = Category::with('product')
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
    public function update(CategoryRequest $request, $id)
    {
        $request->validated();
        Category::where('id', $id)->update($request->all());
        $response = Category::with('product')
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
        $response = Category::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
