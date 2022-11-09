<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use App\Traits\ApiResponse;
use Exception;

class UnitController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Unit::all();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        try{
            $request->validated();
            $response = Unit::create($request->all());

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
        $response = Unit::where('id', $id)->first();
        return $this->apiSuccess($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $request->validated();
        Unit::where('id', $id)->update($request->all());
        $response = Unit::where('id', $id)->first();
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
        $response = Unit::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
