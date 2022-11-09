<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Plotting;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PlottingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Plotting Table';
        $tables = Plotting::with('user_customer')->with('user_seller')
                        ->get();
        return view('operators.plottings.index', compact([
            'title',
            'tables'
        ]));
    }

    public static function get_ward($user_id){
        $res = UserAddress::with('address')->where('user_id', $user_id)->get();
        return $res;
    }

    public static function get_ward_name($ward_id){
        if($ward_id == null){
            return 'None';    
        }
        
        $ward = json_decode(Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$ward_id)->body());
        return $ward->nama;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Plotting Table';
        $tables = Plotting::with('user_customer')->with('user_seller')->where('id', $id)->first();
        return view('operators.plottings.show', compact([
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
        $title = 'Plotting Table';
        $tables = Plotting::with('user_customer')->with('user_seller')->where('id', $id)->first();
        $address_customer = UserAddress::with('address')->where('user_id', $tables->user_customer->user_id)->first();
        $seller = UserAddress::select(['user_sellers.id as seller_id', 'user_sellers.name', 'addresses.province', 'addresses.city', 'addresses.districts', 'addresses.ward', 'user_addresses.user_id'])
                    ->join('user_sellers', 'user_sellers.user_id', '=', 'user_addresses.user_id')
                    ->join('addresses', 'addresses.id', '=', 'user_addresses.addresses_id')
                    ->where('addresses.ward', $address_customer->address->ward)
                    ->get();

        // $provinsi = json_decode(Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi')->body())->provinsi;
        // $city = json_decode(Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota')->body())->kota_kabupaten;
        // $districts = json_decode(Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan')->body())->kecamatan;
        $ward = json_decode(Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$address_customer->address->ward)->body());

        return view('operators.plottings.edit', compact([
            'title', 'tables', 'seller', 'ward'
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
            'user_seller_id' => 'required',
        ]);

        Plotting::where('id', $id)->update([
            'user_seller_id' => $request->user_seller_id,
        ]);

        return redirect()->to('/operator/plotting')
                    ->with('success', 'Data changed successfully!');
    }
}