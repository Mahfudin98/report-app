<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembersCollection;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\UserActivity as UserActivityHelper;

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

    public function store(Request $request)
    {
        $user = request()->user();
        $this->validate($request, [
            'member_name'   => 'required',
            'member_phone'  => 'required',
            'district_id'   => 'required',
            'join_on'       => 'nullable',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'member_type'   => 'required',
        ]);
        $filename = '';

        if ($request->hasFile('image') != '') {
            $file = $request->file('image');
            $filename = time() . Str::slug($request->member_name) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/member', $filename);
        } else {
            $filename = null;
        }

        DB::beginTransaction();
        try {
            $member = Member::create([
                'user_id'       => $user->id,
                'member_name'   => $request->member_name,
                'member_phone'  => $request->member_phone,
                'member_alamat' => $request->member_alamat,
                'district_id'   => $request->district_id,
                'join_on'       => $request->join_on,
                'image'         => $filename,
                'member_type'   => $request->member_type,
                'member_status' => true,
            ]);
            DB::commit();
            UserActivityHelper::addToLog($request->member_type != 0 ? 'Add Member Agen ' . $request->member_name : 'Add Member Reseller ' . $request->member_name);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
