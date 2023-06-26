<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\MarketPlace;
use App\Models\MarketPlaceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\UserActivity as UserActivityHelper;

class ApiMarketPlaceController extends Controller
{
    function index()
    {
        $mp = MarketPlace::all();
        return response()->json(['data' => $mp], 200);
    }

    function store(Request $request)
    {
        $this->validate($request, [
            'market_place_name' => 'required'
        ]);

        MarketPlace::create([
            'market_place_name' => $request->market_place_name
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    function update(Request $request, $id)
    {
        $mp = MarketPlace::find($id);
        $mp->update([
            'market_place_name' => $request->market_place_name,
            'status' => $request->status
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    function storeOrder(Request $request)
    {
        $this->validate($request, [
            'market_place_id' => 'required',
            'order_product'   => 'required',
            'order_omset'     => 'required',
            'order_date'      => 'required',
            'description'     => 'nullable',
        ]);

        $user = request()->user();
        $charactersLength = strlen(strtoupper('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'));
        $randomString = '';
        for ($i = 0; $i < 9; $i++) {
            $randomString .= strtoupper('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')[rand(0, $charactersLength - 1)];
        }
        $code = $randomString . mt_rand(1000, 9999);

        DB::beginTransaction();
        try {
            $mpOrder = MarketPlaceOrder::create([
                'user_id'         => $user->id,
                'market_place_id' => $request->market_place_id,
                'order_id'        => $code . '-' . $user->username,
                'order_product'   => $request->order_product,
                'order_omset'     => $request->order_omset,
                'order_date'      => $request->order_date,
                'description'     => $request->description,
            ]);
            DB::commit();
            UserActivityHelper::addToLogTR('menambahkan report marketplace', $request->order_date);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    function destroyOrder($code)
    {
        $user = request()->user();
        $mpOrder = MarketPlaceOrder::where('order_id', $code)->where('user_id', $user->id)->first();
        UserActivityHelper::addToLog('Remove Order_id ' . $code . '');
        $mpOrder->delete();
        return response()->json(['status' => 'success']);
    }
}
