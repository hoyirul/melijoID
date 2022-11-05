<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Plotting;
use App\Models\UserAddress;
use App\Models\UserCustomer;
use App\Models\UserSeller;
use Illuminate\Http\Request;

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

        return view('operators.plottings.edit', compact([
            'title', 'tables', 'seller'
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