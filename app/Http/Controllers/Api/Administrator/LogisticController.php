<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Logistic;
use App\Models\LogisticCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticController extends Controller
{
    public function index()
    {
        $logistic = DB::table('logistics')
            ->leftJoin('logistic_categories', 'logistics.logistic_category_code', '=', 'logistic_categories.category_code')
            ->select('logistics.*',
                'logistic_categories.parent_category_id',
                'logistic_categories.category_code',
                'logistic_categories.category_name',
                'logistic_categories.category_type',
                // 'logistic_categories.keterangan',
            );
            if (request()->q != '') {
                $logistic = $logistic->where(
                    'nama_barang',
                    'LIKE',
                    '%' . request()->q . '%'
                );
            }
        return response()->json(['status' => 'success', 'data' => $logistic->get(), 'message' => 'Data load successfully.'], 200);
    }

    public function editLogistic($id)
    {
        $logistic = Logistic::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $logistic, 'message' => 'Data load successfully.'], 200);
    }

    public function editCategory($code)
    {
        $category = LogisticCategory::where('category_code', $code)->first();
        return response()->json(['status' => 'success', 'data' => $category, 'message' => 'Data load successfully.'], 200);
    }

    public function storeCategory(Request $request)
    {
        $this->validate($request, [
            'parent_category_id' => 'nullable',
            'category_name' => 'required|string',
            'category_type' => 'nullable|string',
            'keterangan'    => 'nullable',
        ]);

        $charactersLength = strlen(strtoupper($request->category_name));
        $randomString = '';
        for ($i = 0; $i < 3; $i++) {
            $randomString .= strtoupper($request->category_name)[rand(0, $charactersLength - 1)];
        }
        $code = $randomString. mt_rand(1000, 9999);
        DB::beginTransaction();
        try {
            $category = LogisticCategory::create([
                'parent_category_id' => $request->parent,
                'category_code' => $code,
                'category_name' => $request->category_name,
                'category_type' => $request->category_type,
                'keterangan'    => $request->keterangan,
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $category], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function storeLogistic(Request $request)
    {
        $this->validate($request, [
            'logistic_category_code' => 'nullable',
            'nama_barang'            => 'required|string',
            'stock_logistic'         => 'required|integer',
            'satuan'                 => 'required|string',
            'keterangan'             => 'nullable',
        ]);
        DB::beginTransaction();
        try {
            $logistic = Logistic::create([
                'logistic_category_code' => $request->logistic_category_code,
                'nama_barang'            => $request->nama_barang,
                'stock_logistic'         => $request->stock_logistic,
                'satuan'                 => $request->satuan,
                'keterangan'             => $request->keterangan,
            ]);
            DB::commit();
            return response()->json(['status' => 'success', 'data' => $logistic], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function selectCategory()
    {
        $category = LogisticCategory::all();
        $data = [];
        foreach ($category as $row) {
            $logistic = Logistic::where('logistic_category_code', $row->category_code)->get();
            $data[] = [
                'code'   => $row->category_code,
                'parent' => $row->parent_category_id,
                'nama'   => $row->category_name,
                'type'   => $row->category_type,
                'keterangan' => $row->keterangan,
                'logistic'   => $logistic->count(),
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data, 'message' => 'Data load successfully.'], 200);
    }

    public function updateLogistic(Request $request, $id)
    {
        $logistic = Logistic::where('id', $id)->first();
        try {
            $logistic->update([
                'logistic_category_code' => $request->logistic_category_code != "" ? $request->logistic_category_code : $logistic->logistic_category_code,
                'nama_barang'            => $request->nama_barang != "" ? $request->nama_barang : $logistic->nama_barang,
                'stock_logistic'         => $request->stock_logistic != "" ? $request->stock_logistic : $logistic->stock_logistic,
                'satuan'                 => $request->satuan != "" ? $request->satuan : $logistic->satuan,
                'keterangan'             => $request->keterangan != "" ? $request->keterangan : $logistic->keterangan,
                'status_logistic'        => $request->status_logistic != "" ? $request->status_logistic : $logistic->status_logistic,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateCategoryLogistic(Request $request, $code)
    {
        $category = LogisticCategory::where('category_code', $code)->first();

        try {
            $category->update([
                'category_name' => $request->category_name,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
