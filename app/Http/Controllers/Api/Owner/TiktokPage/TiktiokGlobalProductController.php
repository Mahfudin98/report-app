<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokGlobalProductController extends Controller
{
    public function getGlobalProduct()
    {
        $user = request()->user();
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/product/global_products/search?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
