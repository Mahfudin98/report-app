<?php

namespace App\Http\Controllers\Api\Owner\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TiktokKey;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TiktokDashboardController extends Controller
{
    public function linePenghasilan()
    {
        $response = Http::post(
            'https://open-api.tiktokglobalshop.com/api/orders/detail/query?'
                . request()->getQueryString()
        );

        $detail = json_decode($response)->data->order_list;
        $collect = collect($detail)->sortBy('create_time');
        $data = [];

        foreach ($collect as $row) {
            $date = Carbon::createFromTimestamp(substr($row->create_time, 0, -3))->format('Y-m-d');
            $time = Carbon::createFromTimestamp(substr($row->create_time, 0, -3))->format('H:m');
            $count = $row->payment_info->total_amount;
            $data[] = [
                'date' => $date,
                'time' => $time,
                'count' => $count,
            ];
        }
        $group = collect($data)->groupBy('date');
        foreach ($group as $key => $value) {
            $datas[] = [
                'date' => $key,
                'total' => $value->sum('count'),
                'data' => $value->all(),
            ];
        }

        return response()->json(['data' => $datas], 200);
    }
}
