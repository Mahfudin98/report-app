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
        $message = json_decode($response)->message;
        $datas = [];
        if ($message == "Success") {
            # code...
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
        } else {
            $datas[] = [
                'date' => null,
                'total' => null,
                'data' => null,
            ];
        }

        return response()->json(['data' => $datas, 'status' => $message], 200);
    }
    public function linePenjualan()
    {
        $response = Http::post(
            'https://open-api.tiktokglobalshop.com/api/orders/detail/query?'
                . request()->getQueryString()
        );
        $message = json_decode($response)->message;
        $datas = [];
        if ($message == "Success") {
            $detail = json_decode($response)->data->order_list;
            $collect = collect($detail)->sortBy('create_time');
            $data = [];

            foreach ($collect as $row) {
                $date = Carbon::createFromTimestamp(substr($row->create_time, 0, -3))->format('Y-m-d');
                $time = Carbon::createFromTimestamp(substr($row->create_time, 0, -3))->format('H:m');
                $item = collect($row->item_list)->sortBy('create_time')->sum('quantity');
                $data[] = [
                    'date' => $date,
                    'time' => $time,
                    'item' => $item,
                ];
            }

            $group = collect($data)->groupBy('date');
            foreach ($group as $key => $value) {
                $datas[] = [
                    'date' => $key,
                    'total' => $value->sum('item'),
                    'data' => $value->all(),
                ];
            }
        } else {
            $datas[] = [
                'date' => null,
                'total' => null,
                'data' => null,
            ];
        }

        return response()->json(['data' => $datas, 'status' => $message], 200);
    }

    public function topPenghasilan()
    {
        $response = Http::post(
            'https://open-api.tiktokglobalshop.com/api/orders/detail/query?'
                . request()->getQueryString()
        );

        $message = json_decode($response)->message;
        $datas = [];
        if ($message == "Success") {
            $detail = json_decode($response)->data->order_list;
            $collect = collect($detail)->sortBy('create_time');
            $data = [];

            foreach ($collect as $row) {
                foreach ($row->item_list as $value) {
                    $data[] = [
                        'id' => $value->product_id,
                        'total' => $row->payment_info->original_shipping_fee
                            + $value->sku_original_price
                            - $row->payment_info->platform_discount
                            - $row->payment_info->seller_discount
                            - $row->payment_info->shipping_fee_platform_discount
                            - $row->payment_info->shipping_fee_seller_discount
                            + $row->payment_info->taxes,
                        'product_name' => $value->product_name,
                        'sku_image' => $value->sku_image
                    ];
                }
            }

            $group = collect($data)->groupBy('id');
            foreach ($group as $key => $value) {
                $datas[] = [
                    'id' => $key,
                    'amount' => $value->sum('total'),
                    'data' => $value->values()->all(),
                ];
            }
        } else {
            $datas[] = [
                'id' => null,
                'amount' => null,
                'data' => null,
            ];
        }

        return response()->json(['data' => $datas, 'status' => $message], 200);
    }

    public function topPenjualan()
    {
        $response = Http::post(
            'https://open-api.tiktokglobalshop.com/api/orders/detail/query?'
                . request()->getQueryString()
        );

        $message = json_decode($response)->message;
        $datas = [];
        if ($message == "Success") {
            $detail = json_decode($response)->data->order_list;
            $collect = collect($detail)->sortBy('create_time');
            $data = [];

            foreach ($collect as $row) {
                foreach ($row->item_list as $value) {
                    $data[] = [
                        'id' => $value->product_id,
                        'total' => $value->quantity,
                        'product_name' => $value->product_name,
                        'sku_image' => $value->sku_image
                    ];
                }
            }

            $group = collect($data)->groupBy('id');
            foreach ($group as $key => $value) {
                $datas[] = [
                    'id' => $key,
                    'qty' => $value->sum('total'),
                    'data' => $value->values()->all(),
                ];
            }
        } else {
            $datas[] = [
                'id' => null,
                'qty' => null,
                'data' => null,
            ];
        }

        return response()->json(['data' => $datas, 'status' => $message], 200);
    }
}
