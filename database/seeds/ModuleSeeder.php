<?php

use Illuminate\Database\Seeder;
//use App\Models\BaseModel\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'name' => "User",
                'description' => "User Module",
                'pathname' => "User",
                'active' => true,
            ],
            [
                'name' => "Admin",
                'description' => "Admin Module",
                'pathname' => "Admin",
                'active' => true,
            ],
            [
                'name' => "Admin Management",
                'description' => "Admin Management Module",
                'pathname' => "AdminManagement",
                'active' => true,
            ],
            [
                'name' => "Module Management",
                'description' => "Module Management Module",
                'pathname' => "ModuleManagement",
                'active' => true,
            ]
        ]);
    }
}
