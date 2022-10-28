<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\HeaderTransaction;
use App\Models\Payment;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    use ApiResponse;

    public function index($customer_id){
        $response = Payment::select('*')->join('header_transactions', 'header_transactions.txid', 'payments.txid')
                        ->join('user_customers', 'user_customers.id', 'header_transactions.user_customer_id')
                        ->where('header_transactions.user_customer_id', $customer_id)->get();
        if($response == null){
            return $this->apiError('No payments yet!', 422);
        }

        return $this->apiSuccess($response);
    }

    public function store(PaymentRequest $request)
    {
        $invoice = 'INV-'.strtoupper(Str::random(12));

        $validated = $request->validated();
        
        $headers = HeaderTransaction::where('txid', $validated['txid'])->first();

        if($headers == null){
            return $this->apiError('Transaction does not exist!', 422);
        }else if($validated['pay'] > $headers->total || $validated['pay'] < $headers->total){
            return $this->apiError('The nominal must be the same as the total transaction!', 422);
        }

        $validated['evidence_of_transfer'] = $request->file('evidence_of_transfer')->store('payments/'.$validated['txid'], 'public');

        $response = Payment::create([
            'txid' => $validated['txid'],
            'invoice' => $invoice,
            'evidence_of_transfer' => ($validated['evidence_of_transfer'] == null) ? null : $validated['evidence_of_transfer'],
            'paid_date' => Carbon::now(),
            'pay' => $validated['pay'],
            'status' => 'processing'
        ]);

        HeaderTransaction::where('txid', $validated['txid'])->update([
            'status' => 'processing'
        ]);

        return $this->apiSuccess($response);
    }
}
