<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberAdress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery\Undefined;

class RajaOngkirController extends Controller
{
    protected $API_KEY = '12702fd83b0deca04b259899de0a9409';

    public function provinsi()
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://pro.rajaongkir.com/api/province');

        $provinces = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get All Provinces',
            'data'    => $provinces
        ]);
    }

    public function kota($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://pro.rajaongkir.com/api/city?province=' . $id . '');

        $cities = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get City By ID Provinces : ' . $id,
            'data'    => $cities
        ]);
    }

    public function kabupaten()
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://pro.rajaongkir.com/api/city');

        $cities = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'data'    => $cities
        ]);
    }

    public function kecamatan($id)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->get('https://pro.rajaongkir.com/api/subdistrict?city=' . $id . '');

        $districts = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Get District By ID Cities : ' . $id,
            'data'    => $districts
        ]);
    }

    public function cekOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => $this->API_KEY
        ])->post('https://pro.rajaongkir.com/api/cost', [
            'origin'            => 252,
            'originType'        => 'city',
            'destination'       => $request->destination,
            'destinationType'   => 'subdistrict',
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ]);

        $ongkir = $response['rajaongkir']['results'];

        return response()->json([
            'success' => true,
            'message' => 'Result Cost Ongkir',
            'data'    => $ongkir[0]['costs'][0]['cost'][0]['value']
        ]);
    }

    public function memberByProvince()
    {
        $members = DB::table('members')
            ->leftJoin('member_adresses', 'members.id', '=', 'member_adresses.member_id')
            ->select(
                'members.*',
                'member_adresses.member_code',
                'member_adresses.provinsi',
                'member_adresses.kota',
                'member_adresses.kecamatan',
            )
            ->where('members.member_status', 1)
            ->groupBy('members.id')
            ->orderBy('members.member_name', 'ASC')->get();
        $data = [];
        foreach ($members as $row) {
            $image = Storage::disk('public')->url('member/' . $row->image);
            $data[] = [
                'member_id'      => $row->id,
                'member_name'    => $row->member_name,
                'member_phone'   => $row->member_phone,
                'member_provinsi'   => $row->provinsi,
                'member_kota'       => $row->kota,
                'member_kecamatan'  => $row->kecamatan,
                'member_image'   => $row->image != null ? $image : null,
                'member_type'    => $row->member_type == 0 ? 'Reseller' : 'Agen',
                'member_status'  => "Aktif",
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function getMemberByIdProv($id)
    {
        $members = Member::where('member_status', 1)->where('province_id', $id)->get();
        $data = [];
        foreach ($members as $row) {
            $data[] = [
                'member_id'     => $row->id,
                'nama_member'   => $row->member_name,
                'phone_member'  => $row->member_phone,
                'alamat_member' => $row->member_alamat,
                'province_id'   => $row->province_id,
                'city_id'       => $row->city_id,
                'district_id'   => $row->district_id,
                'member_type'   => $row->member_type,
                'member_status' => $row->member_status,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    function addMemberAddress()
    {
        $members = Member::all();
        foreach ($members as $member) {
            $member_code = md5($member->member_name . $member->member_phone . $member->join_on);
            $province = 'Belum diatur';
            $city = 'Belum diatur';
            if ($member->province_id != null && $member->city_id != null && $member->province_id != 'undefined') {
                $province = Http::withHeaders([
                    'key' => $this->API_KEY
                ])->get('https://pro.rajaongkir.com/api/province?id=' . $member->province_id)
                    ->json()['rajaongkir']['results']['province'];
                $city = Http::withHeaders([
                    'key' => $this->API_KEY
                ])->get('https://pro.rajaongkir.com/api/city?id=' . $member->city_id)
                    ->json()['rajaongkir']['results']['city_name'];
            }
            $district = Http::withHeaders([
                'key' => $this->API_KEY
            ])->get('https://pro.rajaongkir.com/api/subdistrict?id=' . $member->district_id)
                ->json()['rajaongkir']['results']['subdistrict_name'];
            $member_address = new MemberAdress();
            $member_address->member_id = $member->id;
            $member_address->member_code = $member_code;
            $member_address->provinsi = $province;
            $member_address->kota = $city;
            $member_address->kecamatan = $district;
            $member_address->save();
        }
        return response()->json(['status' => 'success', 'data' => $member_address], 200);
    }
}
