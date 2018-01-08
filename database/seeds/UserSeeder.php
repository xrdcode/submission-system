<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('secret'),
            'phone' => "08123" . rand(100, 999) .  rand(100, 999),
            'address' => str_random(50),
            'api_token' => str_random(60),
            'email_token' => str_random(50),
            'birthdate' => \Carbon\Carbon::now(),
        ]);
    }
}
