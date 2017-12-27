<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cities = [
            '臺北市',
            '新北市',
            '桃園市',
            '臺中市',
            '臺南市',
            '高雄市',
            '基隆市',
            '新竹市',
            '嘉義市',
            '新竹縣',
            '苗栗縣',
            '彰化縣',
            '南投縣',
            '雲林縣',
            '嘉義縣',
            '屏東縣',
            '宜蘭縣',
            '花蓮縣',
            '臺東縣',
            '澎湖縣',
            '金門縣',
            '連江縣',
        ];

        DB::table('location')->truncate();

        foreach ($cities as $city){
            DB::table('location')
                ->insert([
                    'city' => $city,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }
    }
}
