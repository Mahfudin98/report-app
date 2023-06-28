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
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;
        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));

        $mpOrder = DB::table('market_places')
            ->join('market_place_orders', 'market_places.id', '=', 'market_place_orders.market_place_id')
            ->whereYear('market_place_orders.order_date', $year)
            ->whereMonth('market_place_orders.order_date', $month)
            ->select(
                'market_places.id',
                'market_places.market_place_name',
                'market_place_orders.order_date',
                'market_place_orders.order_product',
                'market_place_orders.order_omset',
            )
            ->orderBy('market_place_orders.order_date')
            ->get();

        $groupedOrders = collect($mpOrder)->groupBy('market_place_name');

        $result = [
            'status' => 'success',
            'data' => []
        ];

        foreach ($groupedOrders as $marketPlaceName => $orders) {
            $groupedByDate = $orders->groupBy(function ($order) {
                return Carbon::parse($order->order_date)->format('Y-m-d');
            });

            $data = [];
            foreach ($array_date as $day) {
                $date = $filter . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                $ordersByDate = $groupedByDate->get($date);

                if ($ordersByDate) {
                    $firstOrder = $ordersByDate->first();

                    $data[] = [
                        'order_date' => $date,
                        'order_product' => $ordersByDate->sum('order_product'),
                        'order_omset' => $ordersByDate->sum('order_omset'),
                        'first_order' => [
                            'id' => $firstOrder->id,
                            'order_date' => $firstOrder->order_date,
                            'order_product' => $firstOrder->order_product,
                            'order_omset' => $firstOrder->order_omset,
                        ],
                    ];
                } else {
                    $data[] = [
                        'order_date' => $date,
                        'order_product' => 0,
                        'order_omset' => 0,
                        'first_order' => null,
                    ];
                }
            }

            $result['data'][] = [
                'market_place_name' => $marketPlaceName,
                'orders' => $data,
            ];
        }

        return response()->json($result, 200);
    }

    function barOrder()
    {
        $year = request()->year;
        $month = [];
        for ($i = 0; $i <= 11; $i++) {
            $month[] = date('m', mktime(0, 0, 0, $i + 1, 1, date($year)));
        }

        $mp = DB::table('market_places')
            ->leftJoin('market_place_orders', 'market_places.id', '=', 'market_place_orders.market_place_id')
            ->select(
                DB::raw("(sum(market_place_orders.order_omset)) as total_omset"),
                DB::raw("(sum(market_place_orders.order_product)) as total_product"),
                DB::raw("(DATE_FORMAT(market_place_orders.order_date, '%m')) as month")
            )
            ->where(DB::raw('YEAR(market_place_orders.order_date)'), '=', $year)
            ->orderBy('market_place_orders.order_date')
            ->groupBy(DB::raw("DATE_FORMAT(market_place_orders.order_date, '%m')"))
            ->get();
        $groupedOrders = collect($mp)->groupBy('market_place_name');

        $result = [
            'status' => 'success',
            'data' => []
        ];

        foreach ($groupedOrders as $marketPlaceName => $orders) {
            $groupedByDate = $orders->groupBy(function ($order) {
                return Carbon::parse($order->order_date)->format('Y-m-d');
            });

            $data = [];
            foreach ($month as $day) {
                $date = $day . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                $ordersByDate = $groupedByDate->get($date);

                if ($ordersByDate) {
                    $firstOrder = $ordersByDate->first();

                    $data[] = [
                        'order_date' => $date,
                        'order_product' => $ordersByDate->sum('order_product'),
                        'order_omset' => $ordersByDate->sum('order_omset'),
                        'first_order' => [
                            'id' => $firstOrder->id,
                            'order_date' => $firstOrder->order_date,
                            'order_product' => $firstOrder->order_product,
                            'order_omset' => $firstOrder->order_omset,
                        ],
                    ];
                } else {
                    $data[] = [
                        'order_date' => $date,
                        'order_product' => 0,
                        'order_omset' => 0,
                        'first_order' => null,
                    ];
                }
            }

            $result['data'][] = [
                'market_place_name' => $marketPlaceName,
                'orders' => $data,
            ];
        }

        return response()->json($result, 200);
    }

    function donatOrder()
    {
        $year = request()->year;
        $month = request()->month;
        $mp = DB::table('market_places')
            ->leftJoin('market_place_orders', 'market_places.id', '=', 'market_place_orders.market_place_id')
            ->select(
                'market_places.market_place_name',
                'market_place_orders.*',
            )
            ->whereYear('market_place_orders.order_date', $year)
            ->whereMonth('market_place_orders.order_date', $month)
            ->groupBy('market_place_orders.market_place_id')
            ->selectRaw('market_place_orders.order_omset, sum(order_omset) as total_omset')
            ->selectRaw('market_place_orders.order_product, sum(order_product) as total_product')
            ->get();
        $data = [];
        foreach ($mp as $item) {
            $data[] = [
                'market_place_name' => $item->market_place_name,
                'omset' => $item->total_omset,
                'products' => $item->total_product,
            ];
        }

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}