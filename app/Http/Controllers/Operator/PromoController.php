<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Promo Table';
        $tables = Promo::all();
        return view('operators.promos.index', compact([
            'title',
            'tables'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promo_code = strtoupper('PR'.Str::random(10));
        $title = 'Promo Table';
        return view('operators.promos.create', compact([
            'title', 'promo_code'
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
            'promo_code' => 'required|string|unique:promos|min:6',
            'promo_title' => 'required|string|max:255',
            'promo_description' => 'required|string',
            'promo_end' => 'required',
            'promo_total' => 'required|numeric',
        ]);

        Promo::create([
            'promo_code' => strtoupper($request->promo_code),
            'promo_title' => $request->promo_title,
            'promo_description' => $request->promo_description,
            'promo_end' => $request->promo_end,
            'promo_total' => $request->promo_total,
        ]);

        return redirect()->to('/operator/promo')
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
        $title = 'Promo Table';
        $tables = Promo::where('id', $id)->first();
        return view('operators.promos.show', compact([
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
        $title = 'Promo Table';
        $tables = Promo::where('promo_code', $id)->first();
        return view('operators.promos.edit', compact([
            'title', 'tables'
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
            'promo_title' => 'required|string|max:255',
            'promo_description' => 'required|string',
            'promo_end' => 'required',
            'promo_total' => 'requsired|numeric',
        ]);

        Promo::where('promo_code', $id)->update([
            'promo_title' => $request->promo_title,
            'promo_description' => $request->promo_description,
            'promo_end' => $request->promo_end,
            'promo_total' => $request->promo_total,
        ]);

        return redirect()->to('/operator/promo')
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
        Promo::where('promo_code', $id)->delete();
        return redirect('/operator/promo')->with('success', 'Data deleted successfully!');
    }
}
