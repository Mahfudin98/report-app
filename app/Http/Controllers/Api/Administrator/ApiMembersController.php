<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembersCollection;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class ApiMembersController extends Controller
{
    public function indexCS()
    {
        $user = request()->user();
        $members = Member::where('user_id', $user->id)->orderBy('created_at', 'DESC');
        if (request()->q != '') {
            $members = $members->where(
                'member_name',
                'LIKE',
                '%' . request()->q . '%'
            );
        }
        $data = [];
        foreach ($members->get() as $row) {
            $path = Storage::disk('public')->url('member/'.$row->image);
            $data[] =[
                'nama' => $row->member_name,
                'alamat' => $row->member_alamat,
                'phone' => $row->member_phone,
                'image' => $row->image != null ? $path : 'belum ada image',
                'type' => $row->member_type == 0 ? 'Reseller' : 'Agen',
                'status' => $row->member_status == 0 ? 'Tidak Aktif' : 'Aktif',
            ];
        }

        return new MembersCollection($data);
    }

    public function selectMember()
    {
        $user = request()->user();
        $member = Member::where('user_id', $user->id)->get();
        return response()->json(['status' => 'success', 'data' => $member, 'message' => 'Data load successfully.'], 200);
    }
}
