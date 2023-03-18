<?php

namespace App\Http\Controllers\Api\Owner;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TargetController extends Controller
{
    public function advList()
    {
        $user = DB::table('users')
            ->join('user_details', 'users.id', '=', 'user_details.user_id')
            ->join('divisions', 'divisions.id', '=', 'users.division_id')
            ->where('divisions.division_code', 'ADV4256')
            ->get();
        $data = [];
        foreach ($user as $row) {
            $count = User::where('parent_id', $row->user_id)->where('status', 1)->count();
            $data[] = [
                'id'       => $row->user_id,
                'nama'     => $row->nama_depan . ' ' . $row->nama_belakang,
                'image'    => Storage::disk('public')->url('user/' . $row->image),
                'cs_count' => $count,
            ];
        }
        return response()->json(['status' => "Success", 'data' => $data], 200);
    }
    public function index()
    {
        $id = request()->id;
        $target = DB::table('targets')
            ->leftJoin('user_details', 'targets.user_id', '=', 'user_details.user_id')
            ->select(
                'targets.id',
                'targets.user_id',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.image',
                'targets.target',
                'targets.periode',
            )
            ->where('targets.user_id', $id)
            ->orderBy('targets.periode', "DESC")
            ->get();
        $data = [];
        foreach ($target as $row) {
            $tr = DB::table('transactions')
                ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
                ->join('users', 'transactions.user_id', '=', 'users.id')
                ->where('users.parent_id', $row->user_id)
                ->whereMonth('transactions.tanggal_transaksi', Carbon::parse($row->periode)->format('m'))
                ->whereYear('transactions.tanggal_transaksi', Carbon::parse($row->periode)->format('Y'))
                ->groupBy('transactions.tanggal_transaksi')
                ->selectRaw('transaction_products.*, sum(jumlah_harga) as total')
                ->get();

            $user = User::where('parent_id', $row->user_id)->where('status', 1)->count();
            $actual = $tr->sum('total');
            $i = $row->target;
            // $w = $i / $user;
            $percent = ($actual / $i) * 100;
            $hasil = number_format($percent, 2, '.', '');

            $status = "";
            switch ($hasil) {
                case $hasil >= 100:
                    $status = "Menakjubkan";
                    break;
                case $hasil >= 80:
                    $status = "Sangat Memuaskan";
                    break;
                case $hasil >= 50:
                    $status = "Cukup Memuaskan";
                    break;
                case $hasil < 50:
                    $status = "Tidak Memuaskan";
                    break;
                default:
                    $status = "Tidak Memuaskan";
                    break;
            }

            $data[] = [
                'id'      => $row->id,
                'nama'    => $row->nama_depan . ' ' . $row->nama_belakang,
                'periode' => $row->periode,
                'target'  => $row->target,
                'omset'   => $actual,
                'persen'  => $hasil,
                'status'  => $status,
            ];
        }

        return response()->json(['status' => "Success", 'data' => $data], 200);
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
            ->where('users.status', 1)
            ->where('users.parent_id', '!=', null)
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
            $user = User::where('parent_id', $row->parent_id)->where('status', 1)->count();
            $actual = $row->omset;
            $i = $tData ? $tData->target : 1000000000;
            // $w = $i / $user;
            $percent = ($actual / $i) * 100;
            $hasil = number_format($percent, 2, '.', '');

            $data['month'][] = [
                'target'    => $i,
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
                $user = User::where('parent_id', $row->parent_id)->where('status', 1)->count();
                $minggu = Carbon::parse($tData->periode)->weekNumberInMonth;
                $actual = $row->omset;
                $i = $tData ? $tData->target : 1000000000;
                $t = $i / ($minggu - 1);
                // $w = $i / $user;
                // $f = round($w /  ($minggu - 1));
                $percent = ($actual / $t) * 100;
                $hasil = number_format($percent, 2, '.', '');

                $data['week'][] = [
                    'target'    => $t,
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
                $user = User::where('parent_id', $row->parent_id)->where('status', 1)->count();
                $minggu = Carbon::parse($tData->periode)->weekNumberInMonth;
                $actual = $row->omset;
                $i = $tData ? $tData->target : 1000000000;
                $w = $i / $user;
                $f = round($w /  ($minggu - 1));
                $o = round($f / 6);
                $percent = ($actual / $o) * 100;
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

    public function destroyTarget($id)
    {
        $target = Target::find($id);
        $target->delete();
        return response()->json(['status' => 'success'], 200);
    }
}
