<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\HeaderTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $title = 'Payment Table';
        $tables = Payment::with('header_transaction')
                        ->get();
        return view('operators.payments.inde x', compact([
            'title',
            'tables'
        ]));
    }

    public function paid()
    {
        $title = 'Payment Table';
        $tables = Payment::with('header_transaction')
                        ->where('status', 'paid')
                        ->get();
        return view('operators.payments.index', compact([
            'title',
            'tables'
        ]));
    }

    public function unpaid()
    {
        $title = 'Payment Table';
        $tables = Payment::with('header_transaction')
                        ->where('status', 'unpaid')
                        ->get();
        return view('operators.payments.index', compact([
            'title',
            'tables'
        ]));
    }

    public function processing()
    {
        $title = 'Payment Table';
        $tables = Payment::with('header_transaction')
                        ->where('status', 'processing')
                        ->get();
        return view('operators.payments.index', compact([
            'title',
            'tables'
        ]));
    }

    public function waiting()
    {
        $title = 'Payment Table';
        $tables = Payment::with('header_transaction')
                        ->where('status', 'waiting')
                        ->get();
        return view('operators.payments.index', compact([
            'title',
            'tables'
        ]));
    }

    public function paid_put($txid)
    {
        HeaderTransaction::where('txid')->update([
            'status' => 'paid'
        ]);
        Payment::where('txid', $txid)->update([
            'status' => 'paid'
        ]);

        return redirect()->to('/operator/payment/paid')
                    ->with('success', 'Data changed successfully!');
    }

    public function unpaid_put($txid)
    {
        HeaderTransaction::where('txid')->update([
            'status' => 'unpaid'
        ]);
        Payment::where('txid', $txid)->update([
            'status' => 'unpaid'
        ]);

        return redirect()->to('/operator/payment/unpaid')
                    ->with('success', 'Data changed successfully!');
    }

    public function processing_put($txid)
    {
        HeaderTransaction::where('txid')->update([
            'status' => 'processing'
        ]);
        Payment::where('txid', $txid)->update([
            'status' => 'processing'
        ]);

        return redirect()->to('/operator/payment/processing')
                    ->with('success', 'Data changed successfully!');
    }

    public function waiting_put($txid)
    {
        HeaderTransaction::where('txid')->update([
            'status' => 'waiting'
        ]);
        Payment::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);

        return redirect()->to('/operator/payment/waiting')
                    ->with('success', 'Data changed successfully!');
    }
}
