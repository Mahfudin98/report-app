<?php

namespace App\Http\Controllers\Api\Owner\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function range($request)
    {
        $date = explode(' - ', $request);
        $start = Carbon::parse($date[0])->format('Y-m-d');
        $end = Carbon::parse($date[1])->format('Y-m-d');

        $data = ['start' => $start, 'end' => $end];
        return ($data);
    }

    public function omset()
    {
        $currentDate = Carbon::now();
        $start = $currentDate->today()->format("Y-m-d");
        $end = $currentDate->today()->format("Y-m-d");
        $date = "{$start} - {$end}";

        $convert = "";

        if (request()->date != '') {
            $date = request()->date;
            $convert = $this->range($date);
        } else {
            $convert = $this->range($date);
        }

        $tr = DB::table('transactions')
            ->leftJoin('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->selectRaw('sum(transaction_products.jumlah_harga) as omset')
            ->whereBetween('transactions.tanggal_transaksi', [$convert['start'], $convert['end']])->first();

        return response()->json(['data' => $tr->omset != null ? $tr->omset : 0], 200);
    }

    public function produk()
    {
        $currentDate = Carbon::now();
        $start = $currentDate->today()->format("Y-m-d");
        $end = $currentDate->today()->format("Y-m-d");
        $date = "{$start} - {$end}";

        $convert = "";

        if (request()->date != '') {
            $date = request()->date;
            $convert = $this->range($date);
        } else {
            $convert = $this->range($date);
        }

        $tr = DB::table('transactions')
            ->leftJoin('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->selectRaw('sum(transaction_products.qty) as produk')
            ->whereBetween('transactions.tanggal_transaksi', [$convert['start'], $convert['end']])->first();

        return response()->json(['data' => $tr->produk != null ? $tr->produk : 0], 200);
    }
}
