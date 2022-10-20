<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionProduct;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileDashboardController extends Controller
{
    public function barChart($username)
    {
        $user = User::where('username', $username)->first();
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
}
