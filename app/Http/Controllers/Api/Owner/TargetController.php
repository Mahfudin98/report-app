<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    public function index()
    {
        $target = Target::all();
        return response()->json(['status' => "Success", 'data' => $target], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'   => 'required',
            'periode'   => 'required',
            'target'    => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            $target = Target::create([
                'user_id'   => $request->user_id,
                'periode'   => $request->periode,
                'target'    => $request->target,
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'data' => $target], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function percent($id)
    {
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
            ->groupBy('transactions.user_id')
            ->selectRaw('transaction_products.jumlah_harga, sum(jumlah_harga) as omset, transaction_products.qty, sum(qty) as produk')
            ->orderBy('omset', 'DESC')
            ->get();

        $user = User::where('parent_id', $id)->get();
        $target = Target::where('user_id', $id)->first();
        $week = Carbon::parse($target->periode)->weekNumberInMonth;
        $w = $target->target / $user->count();
        $f = round($w /  ($week - 1 ));
        $o = round($f / 6);

        $actual = 140000;
        $percent = ($actual / $o) * (100/100);
        $hasil = number_format($percent, 2, '.', '') . "%";

        $wo = Carbon::parse($target->periode)->format('W');
        return response()->json(['status' => 'success', 'data' => $wo], 200);
    }
}
