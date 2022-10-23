<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardIndex extends Controller
{
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function lineChart()
    {
        $user = request()->user();
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));

        $tr = DB::table('transactions')
        ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
        ->select(
            'transactions.tanggal_transaksi',
            'transaction_products.*'
        )
        ->where('transactions.user_id', $user->id)
        ->where('transactions.tanggal_transaksi', 'LIKE', '%' . $filter . '%')
        ->groupBy('transactions.tanggal_transaksi')
        ->selectRaw('transaction_products.*, sum(jumlah_harga) as total')
        ->get();

        $data = [];
        $tn = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row:$row;
            $date = $filter . '-' . $f_date;
            $total = $tr->firstWhere('tanggal_transaksi', $date);
            $data[] = [
                'date' => $date,
                'total' => $total ? $total->total:0,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    public function topCS()
    {
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        if (request()->date != '') {
            $date = explode(' - ', request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d');
            $end = Carbon::parse($date[1])->format('Y-m-d');
        }

        $tr = DB::table('transactions')
            ->leftJoin('user_details', 'transactions.user_id', '=', 'user_details.user_id')
            ->leftJoin('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->select(
                'transactions.id',
                'transactions.nomor_pesanan',
                'transaction_products.qty',
                'transaction_products.jumlah_harga',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.image',
            )
            ->whereBetween('transactions.tanggal_transaksi', [$start, $end])
            ->groupBy('transactions.user_id')
            ->selectRaw('transaction_products.jumlah_harga, sum(jumlah_harga) as omset, transaction_products.qty, sum(qty) as produk')
            ->orderBy('omset', 'DESC')
            ->get();
        $data = [];
        foreach ($tr as $row) {
            $data[] = [
                'nama' => $row->nama_depan . " " . $row->nama_belakang,
                'image' => Storage::disk('public')->url('user/'.$row->image),
                'produk' => $row->produk,
                'omset' => $row->omset,
            ];
        }
        return response()->json($this->paginate($data), 200);
    }
}
