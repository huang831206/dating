<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->truncate();

        DB::table('messages')->insert([
            [
                'match_id' => 1,
                'from_user_id' => 1,
                'to_user_id' => 2,
                'type' => 'text',
                'message' => 'hi',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'match_id' => 1,
                'from_user_id' => 2,
                'to_user_id' => 1,
                'type' => 'text',
                'message' => 'hi there',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'match_id' => 1,
                'from_user_id' => 1,
                'to_user_id' => 2,
                'type' => 'text',
                'message' => 'how are you doing?',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
