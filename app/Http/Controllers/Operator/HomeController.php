<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $tables = [];
        $title = 'Dashboard';
        return view('operators.home.index', compact([
            'tables', 'title'
        ]));
    }
}
