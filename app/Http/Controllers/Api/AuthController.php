<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FcmTokenRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Address;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCustomer;
use App\Models\UserSeller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use ApiResponse;

    public function login(LoginRequest $request){
        $validated = $request->validated();
        if(!Auth::attempt($validated)){
            return $this->apiError('Credentials not match', Response::HTTP_UNAUTHORIZED);
        }
        $user = User::where('email', $validated['email'])->first();
        $token = $user->createToken($validated['email'])->plainTextToken;
        $detail = [];
        switch($user->role_id){
            case 3:
                $detail = UserCustomer::where('user_id', $user->id)->first();
                break;
            case 4:
                $detail = UserSeller::where('user_id', $user->id)->first();
                break;
            default:
                return $this->apiError('Error Detail Data!', 422);
                break;
        }
        
        $address = UserAddress::with('address')->where('user_id', $user->id)->first();

        return $this->apiSuccess([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'detail' => $detail,
            'address' => $address,
        ]);
    }

    public function fcm(FcmTokenRequest $request){
        $validated = $request->validated();

        $getFcmToken = User::where('id', $validated['id'])->update([
            'fcm_token' => $validated['fcm_token']
        ]);

        return $this->apiSuccess([
            'message' => 'Success',
            'user' => $getFcmToken
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id']
        ]);

        $row = User::orderBy('id', 'DESC')->first();

        switch($validated['role_id']){
            case 3:
                UserCustomer::create([
                    'user_id' => $row->id,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                ]);
                break;
            case 4:
                UserSeller::create([
                    'user_id' => $row->id,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                ]);
                break;
        }

        Address::create([
            'province' => $validated['province'],
            'city' => $validated['city'],
            'districts' => $validated['districts'],
            'ward' => $validated['ward'],
        ]);

        $address = Address::orderBy('id', 'DESC')->first();

        UserAddress::create([
            'user_id' => $row->id,
            'addresses_id' => $address->id,
        ]);

        $token = $user->createToken($validated['email'])->plainTextToken;

        return $this->apiSuccess([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout()
    {
        try{
            auth()->user()->tokens()->delete();
            return $this->apiSuccess('Tokens Revoked');
        } catch(\Throwable $e){
            throw new HttpResponseException($this->apiError(
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            ));
        }
    }
}
