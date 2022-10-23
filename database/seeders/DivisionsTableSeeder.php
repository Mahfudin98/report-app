<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'division_code' => 'ADV4256',
                'division_name' => 'Advertiser',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'division_code' => 'CUS9178',
                'division_name' => 'Customer Service',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'division_code' => 'CMP3651',
                'division_name' => 'Customer Service MP',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'division_code' => 'CSL7901',
                'division_name' => 'Customer Service Leader',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];
        Division::insert($data);
    }
}
