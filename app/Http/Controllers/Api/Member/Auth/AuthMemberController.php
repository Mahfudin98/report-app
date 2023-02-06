<?php

namespace App\Http\Controllers\Api\Member\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthMemberController extends Controller
{
    public function loginMember(Request $request)
    {
        $this->validate($request, [
            'username'  => 'required',
            'password'  => 'required',
        ]);
        $auth = $request->except(['remember_me']);
        $member = Member::where('username', $request->username)->where('member_status', true)->first();
        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json(['status' => 'failed', 'message' => 'User login failed.'], 401);
        }
        $member->update(['api_token' => Str::random(40)]);
        return response()->json(['status' => 'success', 'data' => $member->api_token, 'message' => 'User login successfully.'], 200);
    }

    public function memberProfile()
    {
        $member = request()->user();
        $data = [
            'username' => $member->username,
            'nama' => $member->member_name,
            'phone' => $member->member_phone,
            'email' => $member->email,
            'image' => $member->image != null ? Storage::disk('public')->url('member/' . $member->image) : null,
            'alamat'    => $member->member_alamat,

            'provinsi' => $member->province_id ? $member->province : null,
            'kota'  => $member->city_id ? $member->city : null,
            'district' => $member->district_id,

            'member_type' => $member->member_type == 1 ? "Agen" : "Reseller",
            'member_status' => $member->member_status == 1 ? "Aktif" : "Nonaktif",
        ];
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function logoutMember()
    {
        $member = request()->user();
        $member->update(['api_token' => null]);
        return response()->json(['status' => 'success', 'data' => $member->api_token], 200);
    }
}
