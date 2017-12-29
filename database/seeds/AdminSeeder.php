<?php

use Illuminate\Database\Seeder;
use App\Models\BaseModel\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin();
        $check = $admin->where('email', 'reysdesign@hotmail.com')->get()->first();
        if(empty($check)) {
            $admin->create([
                'email'     => 'reysdesign@hotmail.com',
                'name'      => 'Muhammad Reyhan Fahlevi',
                'password'  => bcrypt('demo@test'),
                'address'   => 'Jl. Talempong Blok J/1',
                'phone'     => '087785282705',
                'active'    => true,
            ]);
        }
    }
}