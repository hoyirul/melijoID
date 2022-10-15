<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Discount Table';
        $tables = Discount::with('product_discount')
                        ->get();
        return view('operators.discounts.index', compact([
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
        $title = 'Discount Table';
        return view('operators.discounts.create', compact([
            'title'
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
            'title' => 'required',
            'total_discount' => 'required|numeric|between:0.00,99.99',
            'description' => 'required',
        ]);

        Discount::create([
            'title' => $request->title,
            'total_discount' => $request->total_discount,
            'description' => $request->description,
        ]);

        return redirect()->to('/admin/discount')
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
        $title = 'Discount Table';
        $tables = Discount::where('id', $id)->first();
        return view('operators.discounts.show', compact([
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
        $title = 'Discount Table';
        $tables = Discount::where('id', $id)->first();
        return view('operators.discounts.edit', compact([
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
            'title' => 'required',
            'total_discount' => 'required|numeric|between:0.00,99.99',
            'description' => 'required',
        ]);

        Discount::where('id', $id)->update([
            'title' => $request->title,
            'total_discount' => $request->total_discount,
            'description' => $request->description,
        ]);

        return redirect()->to('/admin/discount')
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
        Discount::where('id', $id)->delete();
        return redirect('/admin/discount')->with('success', 'Data deleted successfully!');
    }
}
