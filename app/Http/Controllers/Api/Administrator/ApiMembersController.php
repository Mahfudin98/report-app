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
use App\Models\MemberAdress;
use App\Models\MemberDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ApiMembersController extends Controller
{
    protected $API_KEY = '12702fd83b0deca04b259899de0a9409';
    public function indexCS()
    {
        $members = DB::table('members')
            ->leftJoin('user_details', 'members.user_id', '=', 'user_details.user_id')
            ->leftJoin('member_adresses', 'members.id', '=', 'member_adresses.member_id')
            ->select(
                'members.*',
                'member_adresses.member_code',
                'member_adresses.provinsi',
                'member_adresses.kota',
                'member_adresses.kecamatan',
                'user_details.nama_depan',
                'user_details.image as image_cs',
            )
            ->groupBy('members.id')
            ->orderBy('members.member_name', 'ASC');

        if (request()->q != '') {
            $members = $members->where(
                'member_name',
                'LIKE',
                '%' . request()->q . '%'
            );
        }
        $data = [];
        foreach ($members->get() as $row) {
            $imageCS = Storage::disk('public')->url('user/' . $row->image_cs);
            $imageMember = $row->image != null && $row->image != 'null' ? Storage::disk('public')->url('member/' . $row->image) : null;
            $data[] = [
                'cs_id'    => $row->user_id,
                'cs_name'  => $row->nama_depan,
                'cs_image' => $imageCS,
                'member_id'        => $row->id,
                'member_username'  => $row->username,
                'member_code'      => $row->member_code,
                'member_name'      => $row->member_name,
                'member_image'     => $imageMember,
                'member_provinsi'  => $row->provinsi,
                'member_kota'      => $row->kota,
                'member_kecamatan' => $row->kecamatan,
                'member_type'      => $row->member_type,
                'member_status'    => $row->member_status,
                'member_phone'     => $row->member_phone,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function selectMember($id)
    {
        $member = Member::where('user_id', $id)->where('member_status', 1)->get();
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
                'username'      => Str::slug($request->member_name) . mt_rand(10, 99),
                'password'      => bcrypt('password'),
                'member_name'   => $request->member_name,
                'email'         => $request->email,
                'member_phone'  => $request->member_phone,
                'member_alamat' => $request->member_alamat,
                'province_id'   => $request->province_id,
                'city_id'       => $request->city_id,
                'district_id'   => $request->district_id,
                'join_on'       => $request->join_on,
                'image'         => $filename,
                'member_type'   => $request->member_type,
                'member_status' => true,
            ]);
            // address
            $province = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/province?id=' . $member->province_id)
                ->json()['rajaongkir']['results']['province'];
            $city = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/city?id=' . $member->city_id)
                ->json()['rajaongkir']['results']['city_name'];
            $district = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/subdistrict?id=' . $member->district_id)
                ->json()['rajaongkir']['results']['subdistrict_name'];
            $member_code = md5($member->member_name . $member->member_phone . $member->join_on);
            MemberAdress::create([
                'member_id' => $member->id,
                'member_code' => $member_code,
                'provinsi' => $province,
                'kota' => $city,
                'kecamatan' => $district,
            ]);
            DB::commit();
            UserActivityHelper::addToLog($request->member_type != 0 ? 'Add Member Agen ' . $request->member_name : 'Add Member Reseller ' . $request->member_name);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $member = Member::where('id', $id)->first();
        return response()->json(['status' => 'success', 'data' => $member], 200);
    }

    public function update(Request $request, $id)
    {
        $member = Member::where('id', $id)->first();
        $this->validate($request, [
            'member_name'   => 'required',
            'member_phone'  => 'required',
            'district_id'   => 'nullable',
            'join_on'       => 'nullable',
            'image'         => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
            'member_type'   => 'required',
            'member_status' => 'required'
        ]);
        $filename = $member->image;

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                File::delete(storage_path('app/public/member/' . $filename));
                $filename = time() . Str::slug($request->member_name) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/member', $filename);
            } else {
                $filename = $member->image;
            }
            $district = '';
            if ($request->district_id != '') {
                $district = $request->district_id;
            } else {
                $district = $member->district_id;
            }

            $member->update([
                'member_name'   => $request->member_name,
                'username'      => $request->username,
                'password'      => $request->password != '' ? bcrypt($request->password) : $member->password,
                'member_phone'  => $request->member_phone,
                'member_alamat' => $request->member_alamat,
                'province_id'   => $request->province_id,
                'city_id'       => $request->city_id,
                'district_id'   => $district,
                'join_on'       => $request->join_on,
                'image'         => $filename,
                'member_type'   => $request->member_type,
                'member_status' => $request->member_status,
            ]);
            $province = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/province?id=' . $member->province_id)
                ->json()['rajaongkir']['results']['province'];
            $city = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/city?id=' . $member->city_id)
                ->json()['rajaongkir']['results']['city_name'];
            $district = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/subdistrict?id=' . $member->district_id)
                ->json()['rajaongkir']['results']['subdistrict_name'];
            $adress = MemberAdress::where('member_id', $member->id)->first();
            if ($adress) {
                $adress->update([
                    'provinsi' => $province,
                    'kota' => $city,
                    'kecamatan' => $district,
                ]);
            } else {
                $member_code = md5($member->member_name . $member->member_phone . $member->join_on);
                MemberAdress::create([
                    'member_id' => $member->id,
                    'member_code' => $member_code,
                    'provinsi' => $province,
                    'kota' => $city,
                    'kecamatan' => $district,
                ]);
            }
            DB::commit();
            UserActivityHelper::addToLog($request->member_type != 0 ? 'Update Member Agen ' . $request->member_name : 'Update Member Reseller ' . $request->member_name);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateTable()
    {
        try {
            $member = Member::all();
            foreach ($member as $row) {
                DB::table('members')
                    ->where('id', $row->id)
                    ->update(array('username' => Str::slug($row->member_name) . mt_rand(10, 99), 'password' => bcrypt('password')));
            }
            DB::commit();
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function storeMemberDetail(Request $request, $id)
    {
        $member = Member::find($id);
        $member->update([
            'member_phone' => $request->member_phone != '' ? $request->member_phone : $member->member_phone,
        ]);
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
}
