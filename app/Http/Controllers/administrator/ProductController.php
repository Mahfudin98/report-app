<?php

namespace App\Http\Controllers\administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\UserActivity as UserActivityHelper;
use App\Http\Requests\administrator\StoreProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
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
        UserActivityHelper::addToLog('view product index');
        return view('product.productIndex', compact('products'));
    }

    public function create()
    {
        $category = ProductCategory::all();
        return view('product.productCreate', compact('category'));
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
        $code = $randomString. mt_rand(1000, 9999);

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

        return redirect(route('product-index'))->with(['success' => 'Produk Baru Ditambahkan']);
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
        )->orderBy('products.product_name', 'ASC')->first();
        $category = ProductCategory::all();
        return view('product.productEdit', compact('product', 'category'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $filename = $product->image;
        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            File::delete(storage_path('app/public/product/' . $filename));
            $filename = time() . Str::slug($request->product_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/product', $filename);
        }
        $product->update([
            'category_id'    => $request->category_id,
            'product_code'   => $request->product_code,
            'product_name'   => $request->product_name,
            'product_bpom'   => $request->product_bpom,
            'image'          => $filename,
            'product_stock'  => $request->product_stock,
            'product_weight' => $request->product_weight,
            'product_status' => $request->product_status
        ]);
        $harga = ProductPrice::where('product_id', $product->id)->first();
        $harga->update([
            'end_user'   => $request->end_user,
            'reseller'   => $request->reseller,
            'agen'       => $request->agen
        ]);

        return redirect(route('product-index'))->with(['success' => 'Produk Diedit']);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $price   = ProductPrice::where('product_id', $id)->first();
        File::delete(storage_path('app/public/product/' . $product->image));

        $product->delete();
        $price->delete();

        return back();
    }

    public function productImage($filename)
    {
        $path = storage_path('app/public/product/'.$filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
