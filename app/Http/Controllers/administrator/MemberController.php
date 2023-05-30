<?php

namespace App\Http\Controllers\administrator;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class MemberController extends Controller
{
    public function index()
    {
        $member = DB::table('members')->join('user_details', 'members.user_id', '=', 'user_details.user_id')
            ->select(
                'members.*',
                'user_details.nama_depan',
                'user_details.nama_belakang',
                'user_details.user_id'
            )->orderBy('members.member_name', 'ASC')->get();

        return view('member.memberIndex', compact('member'));
    }

    public function create()
    {
        $cs = DB::table('users')->join('user_details', 'users.id', '=', 'user_details.user_id')->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select(
                'users.*',
                'user_details.*',
                'divisions.division_code',
                'divisions.division_name'
            )->where('divisions.division_code', 'CUS9178')->orWhere('divisions.division_code', 'CMP3651')->orWhere('divisions.division_code', 'CSL7901')->orderBy('user_details.nama_depan', 'ASC')->get();
        return view('member.memberCreate', compact('cs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id'       => 'required',
            'member_name'   => 'required',
            'member_phone'  => 'required',
            'district_id'   => 'required',
            'join_on'       => 'required',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'member_type'   => 'required',
        ]);
        $filename = '';

        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->member_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/member', $filename);
        }

        $member = Member::create([
            'user_id'       => $request->user_id,
            'member_name'   => $request->member_name,
            'member_phone'  => $request->member_phone,
            'member_alamat' => $request->member_alamat,
            'district_id'   => $request->district_id,
            'join_on'       => $request->join_on,
            'image'         => $filename,
            'member_type'   => $request->member_type,
            'member_status' => true,
        ]);

        return redirect(route('member-index'))->with(['success' => 'User Baru Ditambahkan']);
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

    public function memberCard($username)
    {
        $member = DB::table('members')->leftJoin('member_details', 'members.id', '=', 'member_details.member_id')->where('members.username', $username)->first();
        return view('print.idcard', compact('member'));
    }

    public function memberCardPrint($username)
    {
        $member = DB::table('members')->leftJoin('member_details', 'members.id', '=', 'member_details.member_id')->where('members.username', $username)->first();
        $pdf = PDF::loadView('print.idcardStyle', compact('member'));
        return $pdf->download($member->member_name . '.pdf');
        // return $pdf->stream();
    }
}
