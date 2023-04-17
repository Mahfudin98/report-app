<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $members = Member::where('member_status', 1)->get();
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
}
