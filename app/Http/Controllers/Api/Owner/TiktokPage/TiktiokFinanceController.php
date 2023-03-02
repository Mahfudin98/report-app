<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokFinanceController extends Controller
{
    public function getSettlements()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/finance/settlements/search?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getTransactions()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/finance/transactions/search?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getOrderSettlements()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/finance/order/settlements?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
