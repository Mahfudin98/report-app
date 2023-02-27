<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktokKeyController extends Controller
{
    protected $app_key = "66siobfe2g2b9";
    protected $app_secret = "6d3b91e98652cd8fd8584b21eb16e8b0857bb602";
    public function getAccess()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

        return response()->json(['status' => 'success', 'data' => $key], 200);
    }

    public function getAuth()
    {
        $auth_code = request()->auth_code;
        $response = Http::get('https://auth.tiktok-shops.com/api/v2/token/get?app_key=' . $this->app_key . '&auth_code=' . $auth_code . '&app_secret=' . $this->app_secret . '&grant_type=authorized_code');
        $res = json_decode($response->body());
        $data = $res->data;
        $user = request()->user();
        $key = TiktokKey::create([
            'user_id' => $user->id,
            'access_token' => $data->access_token,
            'access_token_expire_in' => $data->access_token_expire_in,
            'refresh_token' => $data->refresh_token,
            'refresh_token_expire_in' => $data->refresh_token_expire_in,
            'open_id' => $data->open_id,
            'seller_name' => $data->seller_name,
        ]);
        return response()->json(json_decode($response->body()), 200);
    }

    public function storeAccess(Request $request)
    {
        $user = request()->user();
        $key = TiktokKey::create([
            'user_id' => $user->id,
            'access_token' => $request->access_token,
            'access_token_expire_in' => $request->access_token_expire_in,
            'refresh_token' => $request->refresh_token,
            'refresh_token_expire_in' => $request->refresh_token_expire_in,
            'open_id' => $request->open_id,
            'seller_name' => $request->seller_name,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function getShop()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $page = request()->page;
        $timestamp = request()->timestamp;
        $sign = request()->sign;
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/' . $page . '?app_key=' . $this->app_key . '&timestamp=' . $timestamp . '&sign=' . $sign . '&access_token=' . $access_token);
        return response()->json(json_decode($response->body()), 200);
    }
}
