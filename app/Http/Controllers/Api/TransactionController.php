<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Cart;
use App\Models\DetailTransaction;
use App\Models\HeaderTransaction;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    use ApiResponse;

    public function index($customer_id){
        $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        ->where('user_customer_id', $customer_id)->first();
        
        if($headers == null){
            return $this->apiError('No transactions yet!', 422);
        }

        $details = DetailTransaction::with('product')->where('txid', $headers->txid)->get();

        $response = [
            'transaction' => $headers,
            'detail_transaction' => $details,
        ];

        return $this->apiSuccess($response);
    }

    public function show_by_seller($seller_id){
        $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        ->where('user_seller_id', $seller_id)->first();
        
        if($headers == null){
            return $this->apiError('No transactions yet!', 422);
        }

        $details = DetailTransaction::with('product')->where('txid', $headers->txid)->get();

        $response = [
            'transaction' => $headers,
            'detail_transaction' => $details,
        ];

        return $this->apiSuccess($response);
    }

    public function update_status_trx($txid){
        HeaderTransaction::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);
        return $this->apiSuccess('Success update data!');
    }

    public function store(TransactionRequest $request)
    {
        $txid = 'TX-'.strtoupper(Str::random(12));
        $validated = $request->validated();
        // dd($validated);
        HeaderTransaction::create([
            'txid' => $txid,
            'user_customer_id' => $validated['user_customer_id'],
            'user_seller_id' => $validated['user_seller_id'],
            'user_operator_id' => ($validated['user_operator_id'] == null) ? null : $validated['user_operator_id'],
            'promo_code' => ($validated['promo_code'] == null) ? null : $validated['promo_code'],
            'date_order' => Carbon::now(),
            'total' => $validated['total']
        ]);

        $carts = Cart::with('product')->where('user_customer_id', $validated['user_customer_id'])->get();
        
        foreach($carts as $row){
            DetailTransaction::create([
                'txid' => $txid,
                'product_id' => $row->product_id,
                'quantity' => $row->quantity,
                'price' => $row->product->price,
                'subtotal' => $row->product->price * $row->quantity 
            ]);
        }

        Cart::where('user_customer_id', $validated['user_customer_id'])->delete();

        $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        ->where('user_customer_id', $validated['user_customer_id'])->first();
        $details = DetailTransaction::with('product')->where('txid', $txid)->get();

        $response = [
            'transaction' => $headers,
            'detail_transaction' => $details,
        ];
        return $this->apiSuccess($response);
    }
}