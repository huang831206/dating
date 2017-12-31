<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->truncate();

        DB::table('profiles')->insert([
            [
                'user_id' => 1,
                'hobby' => 'no',
                'introduction' => 'hi, i\'m ben',
                'gender' => 'boy',
                'location_id' => 1,
                'research_area_id' =>12,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'hobby' => 'lalala',
                'introduction' => 'hi, i\'m test',
                'gender' => 'girl',
                'location_id' => 1,
                'research_area_id' =>12,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
