<?php

namespace App\Http\Controllers\Api\Owner\TiktokPage;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktiokProductController extends Controller
{
    public function uploadFile()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/upload_files?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function uploadImage()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/upload_imgs?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function createProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function deleteProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::delete('https://open-api.tiktokglobalshop.com/api/products?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function editProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::put('https://open-api.tiktokglobalshop.com/api/products?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function updateStock()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::put('https://open-api.tiktokglobalshop.com/api/products/stocks?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getProductList()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/search?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body())->data, 200);
    }

    public function getProductDetail()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/products/details?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function deactivateProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/inactivated_products?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function activateProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/activate?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function recoverDeletedProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/recover?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function updatePrice()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::put('https://open-api.tiktokglobalshop.com/api/products/prices?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getCategories()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/products/categories?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getBrands()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/products/brands?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getAttributes()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/products/attributes?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function getCategoryRule()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::get('https://open-api.tiktokglobalshop.com/api/products/categories/rules?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function categoryRecomended()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/product/category_recommend?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }

    public function createDraftProduct()
    {
        $user = request()->user();
        $key = TiktokKey::where('user_id', $user->id)->orderBy('created_at','DESC')->first();
        $access_token = $key->access_token;
        $response = Http::post('https://open-api.tiktokglobalshop.com/api/products/save_draft?'
            . request()->getQueryString()
        );
        return response()->json(json_decode($response->body()), 200);
    }
}
