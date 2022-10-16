<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOperator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function change_password(){
        $title = 'Change Password';
        return view('operators.settings.change_password', compact([
            'title'
        ]));
    }

    public function update_password(Request $request){
        $request->validate([
            'password' => 'required|min:8|string',
            'password_confirmation' => 'same:password|min:8|required'
        ]);
        
        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect('/operator/change_password')->with('success', 'Password successfully changed');
    }

    public function change_profile(){
        $title = 'Change Profile';
        $tables = UserOperator::where('user_id', Auth::user()->id)->first();
        return view('operators.settings.change_profile', compact([
            'title', 'tables'
        ]));
    }

    public function update_profile(Request $request){
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = null;

        if(Auth::user()->image && file_exists(storage_path('app/public/'. Auth::user()->image))){
            Storage::delete(['public/', Auth::user()->image]);
        }
        
        if($request->image != null){
            $image = $request->file('image')->store('profile/'. Auth::user()->id, 'public');
        }

        User::where('id', Auth::user()->id)
            ->update([
                'image' => ($image == null) ? Auth::user()->image : $image
            ]);
        
        UserOperator::where('user_id', Auth::user()->id)
            ->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
        
        return redirect()->back()
                    ->with('success', 'Profile successfully changed at '. Carbon::now());
    }
}
