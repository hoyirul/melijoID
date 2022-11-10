<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Models\Cart;
use App\Models\DetailTransaction;
use App\Models\HeaderTransaction;
use App\Models\Payment;
use App\Models\Product;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    use ApiResponse;

    public function index($customer_id){
        $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        ->where('user_customer_id', $customer_id)->orderBy('created_at', 'DESC')->get();
        
        if($headers == null){
            return $this->apiError('No transactions yet!', 422);
        }

        // $details = DetailTransaction::with('product')->where('txid', $headers->txid)->get();

        $response = [
            'transaction' => $headers,
            // 'detail_transaction' => $details,
        ];

        return $this->apiSuccess($response);
    }

    public function show_by_seller($seller_id){
        // $headers = DetailTransaction::join('header_transactions', 'header_transactions.txid', '=', 'detail_transactions.txid')
        //                 ->join('products', 'detail_transactions.product_id', '=', 'products.id')
        //                 ->join('product_images', 'products.id', '=', 'product_images.product_id')
        //                 ->where('product_images.carousel', 1)
        //                 ->where('header_transactions.user_seller_id', $seller_id)->get();
        $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        ->where('user_seller_id', $seller_id)->orderBy('created_at')->get();

        if($headers == null){
            return $this->apiError('No transactions yet!', 422);
        }

        $response = [
            'transaction' => $headers,
        ];

        return $this->apiSuccess($response);
    }

    public function update_status_trx($txid){
        HeaderTransaction::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);

        Payment::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);

        $data = HeaderTransaction::with('user_customer')->with('user_seller')
                    ->where('txid', $txid)->first();
        
        $this->push_notif([
            'body' => 'Transaksi telah dikonfirmasi!',
            'title' => 'Transaction & Payment',
        ], $data->user_customer->user->fcm_token);

        return $this->apiSuccess('Success update data!');
    }

    public function update_status_canceled($txid){
        HeaderTransaction::where('txid', $txid)->update([
            'status' => 'canceled'
        ]);

        Payment::where('txid', $txid)->update([
            'status' => 'canceled'
        ]);

        return $this->apiSuccess('Success update data!');
    }

    public function store(TransactionRequest $request)
    {
        $txid = 'TX-'.strtoupper(Str::random(12));
        $validated = $request->validated();
        
        $headers = HeaderTransaction::create([
            'txid' => $txid,
            'user_customer_id' => $validated['user_customer_id'],
            'user_seller_id' => $validated['user_seller_id'],
            'user_operator_id' => ($validated['user_operator_id'] == null) ? null : $validated['user_operator_id'],
            'promo_code' => ($validated['promo_code'] == null) ? null : $validated['promo_code'],
            'date_order' => $validated['date_order'],
            'total' => $validated['total'],
            'information' => $validated['information'],
        ]);

        $carts = Cart::with('product')
                    ->where('user_customer_id', $validated['user_customer_id'])
                    ->whereIn('id', json_decode($validated['cart_id']))
                    ->get();

        foreach($carts as $row){
            DetailTransaction::create([
                'txid' => $txid,
                'product_id' => $row->product_id,
                'quantity' => $row->quantity,
                'price' => $row->product->price,
                'subtotal' => $row->product->price * $row->quantity,
                'grouping' => $txid.'-'.$row->grouping,
            ]);
        }

        Cart::where('user_customer_id', $validated['user_customer_id'])
            ->whereIn('id', json_decode($validated['cart_id']))->delete();

        // $headers = HeaderTransaction::with('user_seller')->with('user_customer')->with('promo')
                        // ->where('user_customer_id', $validated['user_customer_id'])->first();
        $details = DetailTransaction::with('product')->where('txid', $txid)->get();

        $response = [
            'transaction' => $headers,
            'detail_transaction' => $details,
        ];
        return $this->apiSuccess($response);
    }

    public function show($txid){
        $headers = DetailTransaction::with('header_transaction')
                        ->where('txid', $txid)->first();
                        
        $details = DetailTransaction::join('products', 'products.id', '=', 'detail_transactions.product_id')
                        ->join('product_images', 'product_images.product_id', '=', 'products.id')
                        ->where('txid', $txid)
                        ->where('product_images.carousel', 1)
                        ->get();
        
        if($headers == null){
            return $this->apiError('No transactions yet!', 422);
        }

        // $details = DetailTransaction::with('product')->where('txid', $headers->txid)->get();

        $response = [
            'transaction' => $headers,
            'detail_transaction' => $details,
        ];

        return $this->apiSuccess($response);
    }

    public function push_notif($message, $fcm_token){
        $authorized = 'key=AAAACd3VpkQ:APA91bEI6Jy7g7sM-FPLB1WYeFfC8nFX51EVwDxHFy1bKtmPDZltPZtITrpVidzIaUt14zLyXlA4d6I15YnpPjo0zq6EyV06YTNfhynzHUuHJj1Zm4fggX2o69-EWB5pCBPtVqBmW7ou';
        // eTCFbsieTN25j1_FKewN4f:APA91bFhl7yo6UHBdMmT89d7fqFSYVNGEDop37tQA9wuJ0b7U_RKzPgmUT_m16QJYt6zReCJIre2tbp3YGwSRcxALDx6wfJ0H9Crnz2yyfQaLxggO8pt6Ji5HAVQK_fWE8eFiO8MmLby
        Http::accept('application/json')->withHeaders([
            'Authorization' => $authorized
        ])->post('https://fcm.googleapis.com/fcm/send', [
            'registration_ids' => [$fcm_token],
            'notification' => [
                'body' => $message['body'],
                'title' => $message['title']
            ]
        ]);
    }
}