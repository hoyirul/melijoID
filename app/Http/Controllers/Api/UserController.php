<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\UploadProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCustomer;
use App\Models\UserSeller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ApiResponse;

    public function show_profile($user_id){
        $user = User::where('id', $user_id)->first();
        $detail = [];
        switch($user->role_id){
            case 3:
                $detail = UserCustomer::where('user_id', $user->id)->first();
                break;
            case 3:
                $detail = UserSeller::where('user_id', $user->id)->first();
                break;
            default:
                return $this->apiError('Error Detail Data!', 422);
                break;
        }
        
        $address = UserAddress::with('address')->where('user_id', $user->id)->first();

        return $this->apiSuccess([
            'user' => $user,
            'user_detail' => $detail,
            'user_address' => $address,
        ]);
    }

    public function update_profile_image(UploadProfileRequest $request, $id){
        $validated = $request->validated();
        $user = User::where('id', $id)->first();
        if($user->image != null && file_exists(storage_path('app/public/'.$user->image))){
            Storage::delete(['public/', $user->image]);
        }

        $validated['image'] = $request->file('image')->store('profiles/'.$id, 'public');
        
        User::where('id', $id)->update([
            'image' => ($validated['image'] == null) ? '' : $validated['image'],
        ]);

        $response = User::where('id', $id)->first();

        return $this->apiSuccess($response);
    }

    public function update_profile(UserRequest $request, $id)
    {
        $validated = $request->validated();
        User::where('id', $id)->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);
        $user = User::where('id', $id)->first();

        $detail = [];
        switch($user->role_id){
            case 3:
                UserCustomer::where('user_id', $id)->update([
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                ]);
                $detail = UserCustomer::where('user_id', $user->id)->first();
                break;
            case 3:
                UserSeller::where('user_id', $id)->update([
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                ]);
                $detail = UserSeller::where('user_id', $user->id)->first();
                break;
            default:
                return $this->apiError('Error Detail Data!', 422);
                break;
        }

        return $this->apiSuccess([
            'user' => $user,
            'user_detail' => $detail
        ]);
    }

    public function show_address($id)
    {
        $address = UserAddress::with('address')->with('user')->where('user_id', $id)->first();

        return $this->apiSuccess([
            'user_address' => $address
        ]);
    }

    public function update_address(AddressRequest $request, $id)
    {
        $validated = $request->validated();
        $user = UserAddress::with('address')->where('user_id', $id)->first();
        Address::where('id', $user->address->id)->update([
            'province' => $validated['province'],
            'city' => $validated['city'],
            'districts' => $validated['districts'],
            'ward' => $validated['ward'],
        ]);

        $address = UserAddress::with('address')->where('user_id', $id)->first();

        return $this->apiSuccess([
            'user_address' => $address
        ]);
    }
}
