<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsCollection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            )->orderBy('products.product_name', 'ASC');
            if (request()->q != '') {
                $products = $products->where(
                    'products.product_name',
                    'LIKE',
                    '%' . request()->q . '%'
                );
            }
        $data = [];
        foreach ($products->get() as $row) {
            $path = Storage::disk('public')->url('product/'.$row->image);
            $data[] = [
                'code_produk' => $row->product_code,
                'nama_produk' => $row->product_name,
                'weight' => $row->product_weight,
                'stock' => $row->product_stock,
                'image' => $row->image != null ? $path : 'belum ada image',
                'harga_agen' => $row->agen,
                'harga_reseller' => $row->reseller,
                'harga_end_user' => $row->end_user,
                'category_code' => $row->category_code,
                'category' => $row->category_name,
                'type' => $row->category_type,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    public function category()
    {
        $category = ProductCategory::all();
        $data = [];
        foreach ($category as $row) {
            $products = Product::where('category_id', $row->id)->get();
            $data[] = [
                'code' => $row->category_code,
                'category' => $row->category_name,
                'type'  => $row->category_pay,
                'product' => $products->count(),
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
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

    public function listCustomer()
    {
        $products = DB::table('products')->join('product_prices', 'products.id', '=', 'product_prices.product_id')->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_prices.*',
                'product_categories.category_code',
                'product_categories.category_name',
                'product_categories.category_type',
                'product_categories.category_pay'
            )
            ->where('product_categories.category_type', 'bpom')
            ->orderBy('products.product_name', 'ASC');
            if (request()->q != '') {
                $products = $products->where(
                    'products.product_name',
                    'LIKE',
                    '%' . request()->q . '%'
                );
            }
        $data = [];
        foreach ($products->get() as $row) {
            $path = Storage::disk('public')->url('product/'.$row->image);
            $data[] = [
                'code_produk' => $row->product_code,
                'nama_produk' => $row->product_name,
                'stock' => $row->product_stock,
                'image' => $row->image != null ? $path : 'belum ada image',
                'harga_agen' => $row->agen,
                'harga_reseller' => $row->reseller,
                'harga_end_user' => $row->end_user,
                'category_name' => $row->category_name,
                'category_pay' => $row->category_pay,
                'type' => $row->category_type,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    public function listGudang()
    {
        $products = DB::table('products')->join('product_prices', 'products.id', '=', 'product_prices.product_id')->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_prices.*',
                'product_categories.category_code',
                'product_categories.category_name',
                'product_categories.category_type',
                'product_categories.category_pay'
            )
            ->where('product_categories.category_pay', 'ecer')
            ->orderBy('products.product_name', 'ASC');
            if (request()->q != '') {
                $products = $products->where(
                    'products.product_name',
                    'LIKE',
                    '%' . request()->q . '%'
                );
            }
        $data = [];
        foreach ($products->get() as $row) {
            $path = Storage::disk('public')->url('product/'.$row->image);
            $data[] = [
                'code_produk' => $row->product_code,
                'nama_produk' => $row->product_name,
                'stock' => $row->product_stock,
                'image' => $row->image != null ? $path : 'belum ada image',
                'harga_agen' => $row->agen,
                'harga_reseller' => $row->reseller,
                'harga_end_user' => $row->end_user,
                'category_name' => $row->category_name,
                'category_pay' => $row->category_pay,
                'type' => $row->category_type,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }
}
