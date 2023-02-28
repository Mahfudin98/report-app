<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokFulfillmentController extends Controller
{
    public function verifyOrderSplit()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/order_split/verify?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function confirmOrderSplit()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/order_split/confirm?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function searchPreCombinePkg()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/fulfillment/pre_combine_pkg/list?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getPackageShippingDocument()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/fulfillment/shipping_document?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function updatePackageShippingInfo()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/shipping_info/update?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getPackageShippingInfo()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/fulfillment/shipping_info?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function searchPackage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/search?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function shipPackage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/rts?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getPackagePickupConfig()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/fulfillment/package_pickup_config/list?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function removePackageOrder()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/package/remove?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function confirmPrecombinePackage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/pre_combine_pkg/confirm?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getPackageDetail()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/fulfillment/detail?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function fulfillmentUploadImage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/uploadimage?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function updatePackageDeliveryStatus()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/delivery?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function fulfillmentUploadFile()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/uploadfile?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function batchShipPackage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/fulfillment/batch_rts?'
            . request()->getQueryString()
            . '&access_token=' . $access_token
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
