<?php

namespace App\Http\Controllers\Api\Owner\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function lineChart()
    {
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
            ->where('transactions.tanggal_transaksi', 'LIKE', '%' . $filter . '%')
            ->groupBy('transactions.tanggal_transaksi')
            ->selectRaw('transaction_products.*, sum(jumlah_harga) as total')
            ->get();

        $data = [];
        $tn = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $date = $filter . '-' . $f_date;
            $total = $tr->firstWhere('tanggal_transaksi', $date);
            $data[] = [
                'date' => $date,
                'total' => $total ? $total->total : 0,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    public function barChart()
    {
        $year = request()->year;
        $month = [];
        for ($i = 0; $i <= 11; $i++) {
            $month[] = date('m', mktime(0, 0, 0, $i + 1, 1, date($year)));
        }

        $tr = DB::table('transactions')
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->select(
                DB::raw("(sum(transaction_products.jumlah_harga)) as total"),
                DB::raw("(DATE_FORMAT(transactions.tanggal_transaksi, '%m')) as month")
            )
            ->where(DB::raw('YEAR(transactions.tanggal_transaksi)'), '=', $year)
            ->orderBy('transactions.tanggal_transaksi')
            ->groupBy(DB::raw("DATE_FORMAT(transactions.tanggal_transaksi, '%m')"))
            ->get();
        $data = [];
        foreach ($month as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $total = $tr->firstWhere('month', $row);
            $data[] = [
                'date' => $f_date,
                'total' => $total ? $total->total : 0,
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
                'image' => Storage::disk('public')->url('user/' . $row->image),
                'produk' => $row->produk,
                'omset' => $row->omset,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    public function topProduk()
    {
        $pr = DB::table('products')
            ->leftJoin('transaction_products', 'products.id', '=', 'transaction_products.product_id')
            ->select('transaction_products.*', 'products.*')
            ->groupBy('products.id')
            ->selectRaw('transaction_products.qty, sum(qty) as total')
            ->orderBy('total', 'DESC')
            ->get();
        $data = [];
        foreach ($pr as $row) {
            $data[] = [
                'produk' => $row->product_name,
                'qty' => $row->total != null ? $row->total : 0
            ];
        }
        return response()->json($this->paginate($data), 200);
    }

    public function csPerformance()
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
                'transactions.user_id',
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
                'user_id' => $row->user_id,
                'nama' => $row->nama_depan . " " . $row->nama_belakang,
                'image' => Storage::disk('public')->url('user/' . $row->image),
                'produk' => $row->produk,
                'omset' => $row->omset,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    public function chartId($id)
    {
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
            ->where('transactions.user_id', $id)
            ->where('transactions.tanggal_transaksi', 'LIKE', '%' . $filter . '%')
            ->groupBy('transactions.tanggal_transaksi')
            ->selectRaw('transaction_products.*, sum(jumlah_harga) as total')
            ->get();

        $data = [];
        $tn = [];
        foreach ($array_date as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $date = $filter . '-' . $f_date;
            $total = $tr->firstWhere('tanggal_transaksi', $date);
            $data[] = [
                'date' => $date,
                'total' => $total ? $total->total : 0,
            ];
        }
        return response()->json(['data' => $data], 200);
    }

    public function barId($id)
    {
        $year = request()->year;
        $month = [];
        for ($i = 0; $i <= 11; $i++) {
            $month[] = date('m', mktime(0, 0, 0, $i + 1, 1, date($year)));
        }

        $tr = DB::table('transactions')
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->select(
                DB::raw("(sum(transaction_products.jumlah_harga)) as total"),
                DB::raw("(DATE_FORMAT(transactions.tanggal_transaksi, '%m')) as month")
            )
            ->where('transactions.user_id', $id)
            ->where(DB::raw('YEAR(transactions.tanggal_transaksi)'), '=', $year)
            ->orderBy('transactions.tanggal_transaksi')
            ->groupBy(DB::raw("DATE_FORMAT(transactions.tanggal_transaksi, '%m')"))
            ->get();
        $data = [];
        foreach ($month as $row) {
            $f_date = strlen($row) == 1 ? 0 . $row : $row;
            $total = $tr->firstWhere('month', $row);
            $data[] = [
                'date' => $f_date,
                'total' => $total ? $total->total : 0,
            ];
        }
        return response()->json(['data' => $data], 200);
    }
}
