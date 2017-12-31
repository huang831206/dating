<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->command->info('User table seeded!');
        $this->call(ResearchAreaTableSeeder::class);
        $this->command->info('Research area table seeded!');
        $this->call(LocationTableSeeder::class);
        $this->command->info('Loction table seeded!');
        $this->call(ProfilesTableSeeder::class);
        $this->command->info('Profiles table seeded!');
        $this->call(MatchTableSeeder::class);
        $this->command->info('Match table seeded!');
        $this->call(MessagesTableSeeder::class);
        $this->command->info('Message table seeded!');
    }
}
