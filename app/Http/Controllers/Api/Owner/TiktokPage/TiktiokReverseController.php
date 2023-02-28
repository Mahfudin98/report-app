<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokReverseController extends Controller
{
    public function rejectReverseRequest()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/reverse/reverse_request/reject?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getReverseOrderList()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/reverse/reverse_order/list?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function confirmReverseRequest()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/reverse/reverse_request/confirm?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function cancleOrder()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/reverse/order/cancel?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getRejectReasonList()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/reverse/reverse_reason/list?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
