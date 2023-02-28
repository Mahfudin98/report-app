<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TiktiokOrderController extends Controller
{
    public function getOrderDetail()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/orders/detail/query?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getOrderList()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/orders/search?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
