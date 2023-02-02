<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardMemberController extends Controller
{
    public function list()
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $members = DB::table('members')
            ->leftJoin('user_details', 'members.user_id', '=', 'user_details.user_id')
            ->leftJoin('transactions', 'members.id', '=', 'transactions.member_id')
            ->leftJoin('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->select(
                'members.*',
                'user_details.nama_depan',
                'user_details.image as image_cs',
            )
            ->groupBy('members.id')
            ->where('transactions.tanggal_transaksi', 'LIKE', '%' . $filter . '%')
            ->selectRaw('count(transactions.member_id) as point, sum(transaction_products.jumlah_harga) as total')
            ->orderBy('total', 'DESC');

        if (request()->q != '') {
            $members = $members->where(
                'member_name',
                'LIKE',
                '%' . request()->q . '%'
            );
        }
        $data = [];
        foreach ($members->get() as $row) {
            $data[] = [
                'user_id' => $row->user_id,
                'nama_cs' => $row->nama_depan,
                'image_cs' => Storage::disk('public')->url('user/' . $row->image_cs),
                'member_id' => $row->id,
                'nama_member' => $row->member_name,
                'image_member' => $row->image != null && $row->image != 'null' ? Storage::disk('public')->url('member/' . $row->image) : null,
                'phone_member' => $row->member_phone,
                'join_on'   => $row->join_on,
                'alamat_member' => $row->member_alamat,
                'point' => $row->point,
                'total_transaction' => $row->total == null ? 0 : $row->total,
                'member_type' => $row->member_type,
                'member_status' => $row->member_status,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lineChartMemberId()
    {
        $member = request()->user();
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
            ->where('transactions.member_id', $member->id)
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
}
