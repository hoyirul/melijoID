<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\HeaderTransaction;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $m = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

        $no = -1;
        $chart_area = [];
        foreach($m as $x){
            $y = Payment::where('status', 'paid')->orWhere('status', 'waiting')
            ->whereMonth('created_at', '=', $x)
            ->sum('pay');
            $chart_area[] = $y;
        }

        $status = ['paid', 'unpaid', 'processing', 'waiting'];
        $chart_pie = [];
        foreach($status as $x){
            $y = Payment::where('status', $x)
            ->count();
            $chart_pie[] = $y;
        }
        
        $monthly = Payment::where('status', 'paid')->orWhere('status', 'waiting')
                        ->whereMonth('created_at', '=', $month)
                        ->sum('pay');
        $annual = Payment::where('status', 'paid')->orWhere('status', 'waiting')
                        ->whereYear('created_at', '=', $year)
                        ->sum('pay');
        $transactions = HeaderTransaction::where('status', 'processing')->count();
        $users = User::count();
        $title = 'Dashboard';
        return view('operators.home.index', compact([
            'title', 'monthly', 'annual', 'transactions', 'users', 'chart_area', 'chart_pie'
        ]));
    }
}
