<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Traits\ApiResponse;

class RoleController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Role::with('user')
                     ->get();
        return $this->apiSuccess($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $request->validated();
        
        $response = Role::create($request->all());

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
        $response = Role::with('user')
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
    public function update(RoleRequest $request, $id)
    {
        $request->validated();
        Role::where('id', $id)->update($request->all());
        $response = Role::with('user')
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
        $response = Role::where('id', $id)->delete();
        return $this->apiSuccess($response);
    }
}
