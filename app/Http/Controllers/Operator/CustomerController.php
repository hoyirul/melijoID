<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $title = 'Customer Table';
        $tables = UserCustomer::with('user')->get();
        return view('operators.customers.index', compact([
            'title', 'tables'
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Customer Table';
        $roles = Role::where('id', 3)->get();
        $tables = UserCustomer::with('user')->where('id', $id)->first();
        return view('operators.customers.edit', compact([
            'title', 'tables', 'roles'
        ]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|string',
            'role_id' => 'required',
        ]);

        $username = Str::slug($request->name, '-');

        User::where('id', $id)->update([
            'username' => $username,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        UserCustomer::where('user_id', $id)->update([
            'user_id' => $id,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->to('/operator/customer')
                    ->with('success', 'Data changed successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserCustomer::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        return redirect('/operator/customer')->with('success', 'Data deleted successfully!');
    }
}
