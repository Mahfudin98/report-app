<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsCollection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Http\Requests\administrator\StoreProductRequest;
use App\Models\UserActivity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            $path = Storage::disk('public')->url('product/' . $row->image);
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
                'category_pay' => $row->category_pay,
                'status'    => $row->product_status,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    public function store(StoreProductRequest $request)
    {
        $filename = '';

        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->product_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product', $filename);
        }
        $charactersLength = strlen(strtoupper($request->product_name));
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= strtoupper($request->product_name)[rand(0, $charactersLength - 1)];
        }
        $code = $randomString . mt_rand(1000, 9999);

        try {
            $product = Product::create([
                'category_id'   => $request->category_id,
                'product_code'  => $code,
                'product_name'  => $request->product_name,
                'product_bpom'  => $request->product_bpom,
                'image' => $filename != '' ? $filename : null,
                'product_stock' => $request->product_stock,
                'product_weight' => $request->product_weight,
            ]);

            ProductPrice::create([
                'product_id' => $product->id,
                'end_user'   => $request->end_user,
                'reseller'   => $request->reseller,
                'agen'       => $request->agen
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function edit($code)
    {
        $product = Product::where('product_code', $code)->join('product_prices', 'products.id', '=', 'product_prices.product_id')->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.*',
                'product_prices.*',
                'product_categories.category_code',
                'product_categories.category_name',
                'product_categories.category_type',
                'product_categories.category_pay'
            )->first();
        return response()->json(['status' => 'success', 'data' => $product, 'message' => 'Data load successfully.'], 200);
    }

    public function update(Request $request, $code)
    {
        $product = Product::where('product_code', $code)->first();
        $filename = $product->image;
        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            File::delete(storage_path('app/public/product/' . $filename));
            $filename = time() . Str::slug($request->product_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product', $filename);
        }
        try {
            $product->update([
                'category_id'    => $request->category_id != '' ? $request->category_id : $product->category_id,
                'product_code'   => $request->product_code != '' ? $request->product_code : $product->product_code,
                'product_name'   => $request->product_name != '' ? $request->product_name : $product->product_name,
                'product_bpom'   => $request->product_bpom != '' ? $request->product_bpom : $product->product_bpom,
                'image'          => $filename,
                'product_stock'  => $request->product_stock != '' ? $request->product_stock : $product->product_stock,
                'product_weight' => $request->product_weight != '' ? $request->product_weight : $product->product_weight,
                'product_status' => $request->product_status != '' ? $request->product_status : $product->product_status,
            ]);
            $harga = ProductPrice::where('product_id', $product->id)->first();
            $harga->update([
                'end_user'   => $request->end_user != '' ? $request->end_user : $harga->end_user,
                'reseller'   => $request->reseller != '' ? $request->reseller : $harga->reseller,
                'agen'       => $request->agen != '' ? $request->agen : $harga->agen,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function category()
    {
        $category = ProductCategory::all();
        $data = [];
        foreach ($category as $row) {
            $products = Product::where('category_id', $row->id)->get();
            $data[] = [
                'id'   => $row->id,
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
            ->where('products.product_status', 1)
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
            $path = Storage::disk('public')->url('product/' . $row->image);
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
                'product_prices.end_user',
                'product_prices.reseller',
                'product_prices.agen',
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
            $path = Storage::disk('public')->url('product/' . $row->image);
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
                'time' => $row->updated_at,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    public function updateStock(Request $request, $code)
    {
        $products = Product::where('product_code', $code)->first();
        $this->validate($request, [
            'stock'   => 'required|integer',
        ]);
        $date = Carbon::now()->format('Y-m-d H:i:s');
        try {
            $products->update([
                'product_stock' => $request->stock,
            ]);
            DB::commit();
            UserActivityHelper::addToLog($products->product_code);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateActivity($code)
    {
        $activity = DB::table('user_activities')
            ->join('user_details', 'user_activities.user_id', 'user_details.user_id')
            ->join('products', 'user_activities.activity', 'products.product_code')
            ->select(
                'user_activities.activity',
                'user_activities.ip',
                'user_activities.browser',
                'user_activities.date_time',
                'user_details.nama_depan',
                'user_details.image',
                'products.product_name',
            )
            ->where('activity', $code)
            ->orderBy('user_activities.date_time', 'desc')
            ->get();
        $data = [];
        foreach ($activity as $row) {
            $data[] = [
                'image'    => Storage::disk('public')->url('user/' . $row->image),
                'activity' => $row->nama_depan . ' update stock ' . $row->product_name,
                'ip'       => $row->ip,
                'browser'  => $row->browser,
                'date'     => $row->date_time,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    // category
    public function storeCategory(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|string|max:100',
            'category_type' => 'required',
            'category_pay'  => 'required'
        ]);

        $charactersLength = strlen(strtoupper($request->category_name));
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= strtoupper($request->category_name)[rand(0, $charactersLength - 1)];
        }
        $code = $randomString . mt_rand(1000, 9999);

        try {
            ProductCategory::create([
                'category_code' => $code,
                'category_name' => $request->category_name,
                'category_type' => $request->category_type,
                'category_pay'  => $request->category_pay
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
