<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function percent()
    {
        $year = request()->year;
        $month = request()->month;
        $day = request()->day;
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->endOfMonth()->format('Y-m-d');

        if (request()->week != '') {
            $week = explode(' - ', request()->week);
            $start = Carbon::parse($week[0])->format('Y-m-d');
            $end = Carbon::parse($week[1])->format('Y-m-d');
        }

        $tr = DB::table('transactions')
            ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('user_details', 'transactions.user_id', '=', 'user_details.user_id')
            ->leftJoin('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->whereMonth('transactions.tanggal_transaksi', $month)
            ->whereYear('transactions.tanggal_transaksi', $year)
            ->select(
                'transactions.user_id',
                'users.parent_id',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.image',
            );
        $data = [];
        $days = [];
        $weeks = [];
        $months = $tr->groupBy('transactions.user_id')->selectRaw('sum(jumlah_harga) as omset, sum(qty) as produk')->orderBy('omset', 'DESC')->get();
        foreach ($months as $row) {
            $target = Target::where('user_id', $row->parent_id)->whereMonth('periode', $month)->whereYear('periode', $year)->get();
            $tData = $target->firstWhere('user_id', $row->parent_id);
            $user = User::where('parent_id', $row->parent_id)->count();
            $actual = $row->omset;
            $i = $tData ? $tData->target : 1000000000;
            $w = $i / $user;
            $percent = ($actual / $w) * (100/100);
            $hasil = number_format($percent, 2, '.', '');

            $data['month'][] = [
                'target'    => $w,
                'user_id'   => $row->user_id,
                'parent_id' => $row->parent_id,
                'nama'      => $row->nama_depan . ' ' . $row->nama_belakang,
                'image'     => Storage::disk('public')->url('user/' . $row->image),
                'total'     => $row->omset,
                'persent'   => $hasil,
            ];
        }
        if (request()->week != '') {
            $weeks = $tr->whereBetween('transactions.tanggal_transaksi', [$start, $end])->groupBy('transactions.user_id')->selectRaw('sum(jumlah_harga) as omset, sum(qty) as produk')->orderBy('omset', 'DESC')->get();
            foreach ($weeks as $row) {
                $target = Target::where('user_id', $row->parent_id)->whereMonth('periode', $month)->whereYear('periode', $year)->get();
                $tData = $target->firstWhere('user_id', $row->parent_id);
                $user = User::where('parent_id', $row->parent_id)->count();
                $minggu = Carbon::parse($tData->periode)->weekNumberInMonth;
                $actual = $row->omset;
                $i = $tData ? $tData->target : 1000000000;
                $w = $i / $user;
                $f = round($w /  ($minggu - 1 ));
                $percent = ($actual / $f) * (100/100);
                $hasil = number_format($percent, 2, '.', '');

                $data['week'][] = [
                    'target'    => $f,
                    'user_id'   => $row->user_id,
                    'parent_id' => $row->parent_id,
                    'nama'      => $row->nama_depan . ' ' . $row->nama_belakang,
                    'image'     => Storage::disk('public')->url('user/' . $row->image),
                    'total'     => $row->omset,
                    'persent'   => $hasil,
                ];
            }
        } else {
            $data['week'] = null;
        }

        if ($day != '') {
            $days = $tr->where('transactions.tanggal_transaksi', $day)->groupBy('transactions.user_id')->selectRaw('sum(jumlah_harga) as omset, sum(qty) as produk')->orderBy('omset', 'DESC')->get();
            foreach ($days as $row) {
                $target = Target::where('user_id', $row->parent_id)->whereMonth('periode', $month)->whereYear('periode', $year)->get();
                $tData = $target->firstWhere('user_id', $row->parent_id);
                $user = User::where('parent_id', $row->parent_id)->count();
                $minggu = Carbon::parse($tData->periode)->weekNumberInMonth;
                $actual = $row->omset;
                $i = $tData ? $tData->target : 1000000000;
                $w = $i / $user;
                $f = round($w /  ($minggu - 1 ));
                $o = round($f / 6);
                $percent = ($actual / $o) * (100/100);
                $hasil = number_format($percent, 2, '.', '');

                $data['day'][] = [
                    'target'    => $o,
                    'user_id'   => $row->user_id,
                    'parent_id' => $row->parent_id,
                    'nama'      => $row->nama_depan . ' ' . $row->nama_belakang,
                    'image'     => Storage::disk('public')->url('user/' . $row->image),
                    'total'     => $row->omset,
                    'persent'   => $hasil,
                ];
            }
        } else {
            $data['day'] = null;
        }

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
