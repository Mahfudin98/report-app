<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiProductsController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->join('product_prices', 'products.id', '=', 'product_prices.product_id')->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_prices.*',
                'product_categories.category_code',
                'product_categories.category_name',
                'product_categories.category_type',
                'product_categories.category_pay'
            )->orderBy('products.product_name', 'ASC')->get();
        return response()->json(['status' => 'success', 'data' => $products, 'message' => 'Data load successfully.'], 200);
    }

    public function selectProduct()
    {
        $data = DB::table('products')->join('product_prices', 'products.id', '=', 'product_prices.product_id')->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_prices.*',
                'product_categories.category_code',
                'product_categories.category_name',
                'product_categories.category_type',
                'product_categories.category_pay'
            )->orderBy('products.product_name', 'ASC')->get();
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }
}
