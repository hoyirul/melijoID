<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FcmTokenRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Address;
use App\Models\Plotting;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCustomer;
use App\Models\UserSeller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
        $plottings = [];
        switch($user->role_id){
            case 3:
                $detail = UserCustomer::where('user_id', $user->id)->first();
                $plottings = Plotting::where('user_customer_id', $detail->id)->first();
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
            'plotting' => $plottings,
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

        $customer = UserCustomer::where('user_id', $row->id)->first();

        $byward = UserAddress::select(['user_sellers.id as seller_id', 'users.id', 'addresses.ward'])
                    ->join('addresses', 'addresses.id', '=', 'user_addresses.addresses_id')
                    ->join('users', 'users.id', '=', 'user_addresses.user_id')
                    ->join('user_sellers', 'user_sellers.user_id', '=', 'users.id')
                    ->where('addresses.ward', $validated['ward'])
                    ->where('users.role_id', 4)
                    ->orderBy('users.id', 'ASC')
                    ->first();


        $plotting = Plotting::create([
            'user_customer_id' => $customer->id,
            'user_seller_id' => ($byward == null) ? null : $byward->seller_id
        ]);

        $token = $user->createToken($validated['email'])->plainTextToken;

        return $this->apiSuccess([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'plotting' => $plotting,
        ]);
    }

    public function register_seller(RegisterRequest $request)
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

        $wards = json_decode($validated['ward']);

        foreach($wards as $item){
            Address::create([
                'province' => $validated['province'],
                'city' => $validated['city'],
                'districts' => $validated['districts'],
                'ward' => $item,
            ]);
            
            $address = Address::orderBy('id', 'DESC')->first();

            UserAddress::create([
                'user_id' => $row->id,
                'addresses_id' => $address->id,
            ]);
        }

        $token = $user->createToken($validated['email'])->plainTextToken;

        return $this->apiSuccess([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
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

    public function test_fcm(){
        $response = Http::accept('application/json')->withHeaders([
            'Authorization' => 'key=AAAACd3VpkQ:APA91bEI6Jy7g7sM-FPLB1WYeFfC8nFX51EVwDxHFy1bKtmPDZltPZtITrpVidzIaUt14zLyXlA4d6I15YnpPjo0zq6EyV06YTNfhynzHUuHJj1Zm4fggX2o69-EWB5pCBPtVqBmW7ou'
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'registration_ids' => ['eTCFbsieTN25j1_FKewN4f:APA91bFhl7yo6UHBdMmT89d7fqFSYVNGEDop37tQA9wuJ0b7U_RKzPgmUT_m16QJYt6zReCJIre2tbp3YGwSRcxALDx6wfJ0H9Crnz2yyfQaLxggO8pt6Ji5HAVQK_fWE8eFiO8MmLby'],
            'notification' => [
                'body' => 'Test Notification',
                'title' => 'Push notif'
            ]
        ]);

        return $this->apiSuccess($response->body());
    }
}