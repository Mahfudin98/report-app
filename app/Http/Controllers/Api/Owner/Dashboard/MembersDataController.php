<?php

namespace App\Http\Controllers\Api\Owner\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MembersDataController extends Controller
{
    public function listMember()
    {
        $members = DB::table('members')
            ->leftJoin('user_details', 'members.user_id', '=', 'user_details.user_id')
            ->leftJoin('transactions', 'members.id', '=', 'transactions.member_id')
            ->select(
                'members.*',
                'user_details.nama_depan',
                'user_details.image as image_cs',
            )
            ->groupBy('members.id')
            ->selectRaw('count(transactions.member_id) as total')
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
                'username' => $row->username,
                'image_member' => $row->image != null && $row->image != 'null' ? Storage::disk('public')->url('member/' . $row->image) : null,
                'phone_member' => $row->member_phone,
                'join_on'   => $row->join_on,
                'alamat_member' => $row->member_alamat,
                'total_transaction' => $row->total,
                'member_type' => $row->member_type,
                'member_status' => $row->member_status,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function listCSMember()
    {
        $members = DB::table('members')
            ->leftJoin('user_details', 'members.user_id', '=', 'user_details.user_id')
            ->select(
                'user_details.*',
            )
            ->groupBy('user_details.user_id')
            ->selectRaw('count(members.user_id) as total')
            ->orderBy('total', 'DESC')
            ->get();
        $data = [];
        foreach ($members as $row) {
            $data[] = [
                'user_id' => $row->user_id,
                'nama_cs' => $row->nama_depan,
                'image_cs' => Storage::disk('public')->url('user/' . $row->image),
                'total_member' => $row->total,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lineChartMember()
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
            ->where('transactions.member_id', '!=', null)
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

    public function barChartMember()
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
            ->where('transactions.member_id', '!=', null)
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

    public function performanceMember()
    {
        $member = Member::all();
        $data = [
            'total_member' => $member->count(),
            'member_aktif' => $member->where('member_status', 1)->count(),
            'member_nonaktif' => $member->where('member_status', 0)->count(),
            'agenAll' => $member->where('member_type', 1)->count(),
            'resellerAll' => $member->where('member_type', 0)->count(),
            'agenAktif' => $member->where('member_type', 1)->where('member_status', 1)->count(),
            'resellerAktif' => $member->where('member_type', 0)->where('member_status', 1)->count(),
            'agenNonaktif' => $member->where('member_type', 1)->where('member_status', 0)->count(),
            'resellerNonaktif' => $member->where('member_type', 0)->where('member_status', 0)->count(),
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function lineChartMemberId($id)
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
            ->where('transactions.member_id', $id)
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

    public function barChartMemberId($id)
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
            ->where('transactions.member_id', $id)
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

    public function activityID($id)
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;

        $parse = Carbon::parse($filter);
        $array_date = range($parse->startOfMonth()->format('d'), $parse->endOfMonth()->format('d'));
        $tr = DB::table('transactions')
            ->where('transactions.member_id', $id)
            ->where(DB::raw("(STR_TO_DATE(transactions.tanggal_transaksi, '%Y-%m-%d'))"), 'LIKE', '%' . $filter . '%')
            ->get();
        $newDates = [];
        foreach ($tr as $row) {
            $prod = TransactionProduct::where('transaction_id', $row->id)->get();
            $dataTime = DateTime::createFromFormat('Y-m-d', $row->tanggal_transaksi);
            $newDates[$dataTime->format('Y-m-d')][] = [
                'member_id'     => $row->member_id,
                'nomor_pesanan' => $row->nomor_pesanan,
                'product'       => $prod,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $newDates, 'message' => 'Data load successfully.'], 200);
    }

    public function editMember($username)
    {
        $member = Member::where('username', $username)->first();
        return response()->json(['status' => 'success', 'data' => $member, 'message' => 'Data load successfully.'], 200);
    }
}
