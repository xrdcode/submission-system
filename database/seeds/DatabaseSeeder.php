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
        $this->call(MasterSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SystemSettingSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
