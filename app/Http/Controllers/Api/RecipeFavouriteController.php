<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecipeFavouriteRequest;
use App\Models\RecipeFavourite;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RecipeFavouriteController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($customer_id)
    {
        $response = RecipeFavourite::with('user_customer')->with('recipe')
                    ->where('user_customer_id', $customer_id)->get();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeFavouriteRequest $request)
    {
        $request->validated();
        
        $response = RecipeFavourite::create($request->all());

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
        $response = RecipeFavourite::where('id', $id)->first();
        return $this->apiSuccess($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(RecipeFavouriteRequest $request, $id)
    {
        $request->validated();
        RecipeFavourite::where('id', $id)->update($request->all());
        $response = RecipeFavourite::where('id', $id)->first(); 
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
        $response = RecipeFavourite::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
