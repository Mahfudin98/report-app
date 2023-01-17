<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;

class TiktokKeyController extends Controller
{
    public function getAccess()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

        return response()->json(['status' => 'success', 'data' => $key], 200);
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
}
