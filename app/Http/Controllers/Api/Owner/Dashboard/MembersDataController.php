<?php

namespace App\Http\Controllers\Api\Owner\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberDetail;
use App\Models\TransactionProduct;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class MembersDataController extends Controller
{
    protected $API_KEY = '12702fd83b0deca04b259899de0a9409';

    public function getAddress($district, $city)
    {

        $district = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://pro.rajaongkir.com/api/subdistrict?id=' . $district . '&city=' . $city);
        $district_res = $district['rajaongkir']['results'];
        $adress = [
            'provinsi' => $district_res['province'],
            'city' => $district_res['city'],
            'district' => $district_res['subdistrict_name']
        ];

        return $adress;
    }

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
                'image_member_text' => $row->image != null && $row->image != 'null' ? $row->image : null,
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

    public function updateMember(Request $request, $username)
    {
        $member = Member::where('username', $username)->first();
        $filename = $member->image;
        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            File::delete(storage_path('app/public/member/' . $filename));
            $filename = time() . Str::slug($request->member_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/member', $filename);
        }
        try {
            $member->update([
                'user_id' => $request->user_id != '' ? $request->user_id : $member->user_id,
                'username' => $request->username != '' ? $request->username : $member->username,
                'password' => $request->password != '' ? bcrypt($request->password) : $member->password,
                'member_name' => $request->member_name != '' ? $request->member_name : $member->member_name,
                'email' => $request->email != '' ? $request->email : $member->email,
                'member_phone' => $request->member_phone != '' ? $request->member_phone : $member->member_phone,
                'member_alamat' => $request->member_alamat != '' ? $request->member_alamat : $member->member_alamat,
                'province_id' => $request->province_id != '' ? $request->province_id : $member->province_id,
                'city_id' => $request->city_id != '' ? $request->city_id : $member->city_id,
                'district_id' => $request->district_id != '' ? $request->district_id : $member->district_id,
                'join_on' => $request->join_on != '' ? $request->join_on : $member->join_on,
                'image' => $filename,
                'member_type' => $request->member_type != '' ? $request->member_type : $member->member_type,
                'member_status' => $request->member_status != '' ? $request->member_status : $member->member_status,
            ]);
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function memberTop()
    {
        $year = request()->year;
        $month = request()->month;
        $filter = $year . '-' . $month;
        $member = DB::table('transactions')
            ->join('transaction_products', 'transactions.id', '=', 'transaction_products.transaction_id')
            ->rightJoin('members', 'transactions.member_id', '=', 'members.id')
            ->where('transactions.type_customer', 1)
            ->where('transactions.tanggal_transaksi', 'LIKE', '%' . $filter . '%')
            ->select(
                'members.member_name',
                'members.member_alamat',
                'members.image',
                'members.city_id',
                'members.district_id',
                'transactions.tanggal_transaksi',
                'transaction_products.*'
            )
            ->groupBy('transactions.member_id')
            ->selectRaw('transaction_products.*, sum(jumlah_harga) as total')
            ->orderBy('total', 'DESC')
            ->take(3)->get();

        $data = [];
        foreach ($member as $row) {

            $adress = $this->getAddress($row->district_id, $row->city_id);
            $image = Storage::disk('public')->url('member/' . $row->image);
            $data[] = [
                'member_name' => $row->member_name,
                'member_alamat' => $adress['provinsi'] . ', ' . $adress['city'] . ', ' . $adress['district'],
                'image' => $row->image != null ? $image : 'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80',
                'member_type' => 'Agen',
                'date' => $row->tanggal_transaksi,
                'total' => $row->total
            ];
        }

        return response()->json(['data' => $data], 200);
    }

    public function detailMember($username)
    {
        $memberData = Member::where('username', $username)->first();
        $member = MemberDetail::where('member_id', $memberData->id)->first();
        $data = [
            'member_id' => $memberData->id,
            'facebook' => $member != null ? $member->url_fb : null,
            'instagram' => $member != null ? $member->url_ig : null,
            'tiktok' => $member != null ? $member->url_tiktok : null,
            'website' => $member != null ? $member->url_website : null
        ];

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function storeMemberDetail(Request $request, $id)
    {
        $detail = MemberDetail::where('member_id', $id)->first();
        if ($detail == null) {
            MemberDetail::create([
                'member_id' => $id,
                'url_fb' => $request->facebook,
                'url_ig' => $request->instagram,
                'url_tiktok' => $request->tiktok,
                'url_website' => $request->website,
            ]);
        } else {
            $detail->update([
                'url_fb' => $request->facebook,
                'url_ig' => $request->instagram,
                'url_tiktok' => $request->tiktok,
                'url_website' => $request->website,
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function memberImage($filename)
    {
        $path = storage_path('app/public/member/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function memberDetailQR($username)
    {
        $member = DB::table('members')
            ->leftJoin('member_details', 'members.id', '=', 'member_details.member_id')
            ->select(
                'members.*',
                'member_details.url_fb',
                'member_details.url_ig',
                'member_details.url_tiktok',
                'member_details.url_website',
            )
            ->where('members.username', $username)
            ->first();
        $data = [
            'member_id' => $member->id,
            'usernamae' => $member->username,
            'member_name' => $member->member_name,
            'image_member' => $member->image != null && $member->image != 'null' ? Storage::disk('public')->url('member/' . $member->image) : null,
            'member_phone' => $member->member_phone,
            'member_type' => $member->member_type == 1 ? 'Agen' : 'Reseller',
            'join_on' => $member->join_on,
            'status' => $member->member_status == 1 ? 'Aktif' : 'Tidak Aktif',
            'facebook' => $member->url_fb,
            'instagram' => $member->url_ig,
            'tiktok' => $member->url_tiktok,
            'website' => $member->url_website,
        ];
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
