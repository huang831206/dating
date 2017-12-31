<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('matches')->truncate();

        DB::table('matches')->insert([
            [
                'user_a_id' => 1,
                'user_b_id' => 2,
                'hash' => '12345',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
