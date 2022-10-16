<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserOperator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $title = 'Operator Table';
        $tables = UserOperator::with('user')->get();
        return view('operators.operators.index', compact([
            'title', 'tables'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Operator Table';
        $roles = Role::where('id', 1)->orWhere('id', 2)->get();
        return view('operators.operators.create', compact([
            'title', 'roles'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|string',
            'role_id' => 'required',
            'password' => 'required|min:8|string',
            'confirmation_password' => 'required|min:8|same:password|string',
        ]);

        $username = Str::slug($request->name, '-');

        User::create([
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        $user = User::latest()->first();

        UserOperator::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->to('/operator/operator')
                    ->with('success', 'Data added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Operator Table';
        $tables = UserOperator::where('id', $id)->first();
        return view('operators.operators.show', compact([
            'title',
            'tables'
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
        $title = 'Operator Table';
        $roles = Role::where('id', 1)->orWhere('id', 2)->get();
        $tables = UserOperator::with('user')->where('id', $id)->first();
        return view('operators.operators.edit', compact([
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

        UserOperator::where('user_id', $id)->update([
            'user_id' => $id,
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        return redirect()->to('/operator/operator')
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
        UserOperator::where('user_id', $id)->delete();
        User::where('id', $id)->delete();
        return redirect('/operator/operator')->with('success', 'Data deleted successfully!');
    }
}
