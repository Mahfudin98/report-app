<?php

namespace App\Http\Controllers\administrator;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $category = ProductCategory::all();
        return view('category.categoryIndex', compact('category'));
    }

    public function store(Request $request)
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
        $code = $randomString. mt_rand(1000, 9999);

        ProductCategory::create([
            'category_code' => $code,
            'category_name' => $request->category_name,
            'category_type' => $request->category_type,
            'category_pay'  => $request->category_pay
        ]);

        return back()->with(['success' => 'Divisi Ditambahkan']);
    }

    public function edit($code)
    {
        $category = ProductCategory::where('category_code', $code)->first();
        return view('category.categoryEdit', compact('category'));
    }

    public function update(Request $request, $code)
    {
        $category = ProductCategory::where('category_code', $code)->first();
        $this->validate($request, [
            'category_code' => ['required', Rule::unique('product_categories')->ignore($category)],
            'category_name' => 'required|string|max:100',
            'category_type' => 'required',
            'category_pay'  => 'required'
        ]);
        $category->update([
            'category_code' => $request->category_code,
            'category_name' => $request->category_name,
            'category_type' => $request->category_type,
            'category_pay'  => $request->category_pay
        ]);

        return redirect(route('category-index'))->with(['success' => 'Divisi Ditambahkan']);
    }
}
