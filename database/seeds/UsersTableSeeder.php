<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        App\User::create([
            'email' => 'huang831206@gmail.com',
            'name'=>'admin',
            'password'=>Hash::make('123456'),
        ]);

        App\User::create([
            'email' => 't@gmail.com',
            'name'=>'tester',
            'password'=>Hash::make('123456'),
        ]);

        App\User::create([
            'email' => 'tom@gmail.com',
            'name'=>'Tom',
            'password'=>Hash::make('123456'),
        ]);

        App\User::create([
            'email' => 'marry@gmail.com',
            'name'=>'Marry',
            'password'=>Hash::make('123456'),
        ]);

        App\User::create([
            'email' => 'jerry@gmail.com',
            'name'=>'Jerry',
            'password'=>Hash::make('123456'),
        ]);

        App\User::create([
            'email' => 'tina@gmail.com',
            'name'=>'Tina',
            'password'=>Hash::make('123456'),
        ]);
    }
}
