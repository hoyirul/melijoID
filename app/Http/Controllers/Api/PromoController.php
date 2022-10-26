<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $date = Carbon::now();
        $response = Promo::where('promo_end', '>=', $date->format('Y-m-d'))->get();
        return $this->apiSuccess($response);
    }

    public function show($promo_code)
    {
        $response = Promo::where('promo_code', $promo_code)->first();
        return $this->apiSuccess($response);
    }
}
