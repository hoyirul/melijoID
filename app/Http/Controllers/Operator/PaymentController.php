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
        HeaderTransaction::where('txid', $txid)->update([
            'status' => 'paid'
        ]);

        Payment::where('txid', $txid)->update([
            'status' => 'paid'
        ]);

        $data = HeaderTransaction::with('user_customer')->with('user_seller')
                    ->where('txid', $txid)->first();
        
        $this->push_notif([
            'body' => 'Transaksi telah dikonfirmasi!',
            'title' => 'Transaction & Payment',
        ], $data->user_seller->user->fcm_token);

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
