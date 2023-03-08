<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokLogisticsController extends Controller
{
    public function getSubscribedDeliveryOption()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/logistics/get_subscribed_deliveryoptions?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function updateShippingInfo()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/logistics/tracking?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getShippingDocument()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/logistics/shipping_document?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getShippingProvider()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/logistics/shipping_providers?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getShippingInfo()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/logistics/ship/get?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getWarehouseList()
    {
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/logistics/get_warehouse_list?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
