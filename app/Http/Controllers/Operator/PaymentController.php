<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\HeaderTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function index()
    {
        $title = 'Payment All Table';
        $tables = Payment::with('header_transaction')
                        ->get();
        return view('operators.payments.index', compact([
            'title',
            'tables'
        ]));
    }

    public function paid()
    {
        $title = 'Payment Table (Paid)';
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
        $title = 'Payment Table (Unpaid)';
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
        $title = 'Payment Table (Processing)';
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
        $title = 'Payment Table (Waiting)';
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
        $response = Http::post('https://fcm.googleapis.com/v1/projects/melijo-id/messages:send', [
            'Authorization' => 'Bearer AAAACd3VpkQ:APA91bEI6Jy7g7sM-FPLB1WYeFfC8nFX51EVwDxHFy1bKtmPDZltPZtITrpVidzIaUt14zLyXlA4d6I15YnpPjo0zq6EyV06YTNfhynzHUuHJj1Zm4fggX2o69-EWB5pCBPtVqBmW7ou'
        ]);
        HeaderTransaction::where('txid', $txid)->update([
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
        HeaderTransaction::where('txid', $txid)->update([
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
        HeaderTransaction::where('txid', $txid)->update([
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
        HeaderTransaction::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);
        Payment::where('txid', $txid)->update([
            'status' => 'waiting'
        ]);

        return redirect()->to('/operator/payment/waiting')
                    ->with('success', 'Data changed successfully!');
    }
}
