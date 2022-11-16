<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\HeaderTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Transaction Table';
        $tables = HeaderTransaction::with('user_customer')->with('user_seller')->with('promo')
                        ->get();
        return view('operators.transactions.index', compact([
            'title',
            'tables'
        ]));
    }

    public static function get_calc($txid){
        $headers = HeaderTransaction::where('txid', $txid)->first();
        $detail = DetailTransaction::where('txid', $txid)->get();

        $price = [];
        foreach($detail as $row){
            $price[] = ($row->price * (5/100)) * $row->quantity;
        }

        $total = $headers->total;

        $json = [
            'ppn' => array_sum($price),
            'total' => $total - array_sum($price)
        ];

        return $json;
    }

    public static function get_count_transaction(){
        $res = HeaderTransaction::where('status', 'processing')->orWhere('status', 'unpaid')->count();
        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Transaction Table';
        return view('operators.transactions.create', compact([
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
            'category_name' => 'required',
        ]);

        HeaderTransaction::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->to('/operator/category')
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
        $title = 'Transaction Table';
        $tables = HeaderTransaction::where('id', $id)->first();
        return view('operators.transactions.show', compact([
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
        $title = 'Transaction Table';
        $tables = HeaderTransaction::where('id', $id)->first();
        return view('operators.transactions.edit', compact([
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
            'category_name' => 'required',
        ]);

        HeaderTransaction::where('id', $id)->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->to('/operator/category')
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
        HeaderTransaction::where('id', $id)->delete();
        return redirect('/operator/category')->with('success', 'Data deleted successfully!');
    }
}
