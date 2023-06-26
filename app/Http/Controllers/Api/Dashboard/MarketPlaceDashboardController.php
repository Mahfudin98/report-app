<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPlaceDashboardController extends Controller
{
    function index()
    {
        $user = request()->user();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $mplist = DB::table('market_place_orders')
            ->join('market_places', 'market_place_orders.market_place_id', '=', 'market_places.id')
            ->where('market_place_orders.user_id', $user->id)
            ->orderBy('market_place_orders.order_date', request()->order_by);
        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
            $mplist = $mplist->whereBetween('market_place_orders.order_date', [$start, $end]);
        }
        $data = [];
        foreach ($mplist->get() as $item) {
            $data[] = [
                'code' => $item->order_id,
                'market_place' => $item->market_place_name,
                'order_qty' => $item->order_product,
                'order_omset' => $item->order_omset,
                'order_date' => $item->order_date
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    function lineOrder()
    {
    }

    function barOrder()
    {
    }

    function donatOrder()
    {
    }
}
