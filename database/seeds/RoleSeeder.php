<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id'    => 1,
                'name'  => 'RoleManagement-Create',
                'description' => 'Role Management'
            ],
            [
                'id'    => 2,
                'name'  => 'RoleManagement-View',
                'description' => 'Role Management'
            ],
            [
                'id'    => 3,
                'name'  => 'RoleManagement-Save',
                'description' => 'Role Management'
            ],
            [
                'id'    => 4,
                'name'  => 'GroupManagement-Create',
                'description' => 'Group Management'
            ],
            [
                'id'    => 5,
                'name'  => 'GroupManagement-View',
                'description' => 'Group Management'
            ],
            [
                'id'    => 6,
                'name'  => 'GroupManagement-Save',
                'description' => 'Group Management'
            ]
        ]);

        DB::table('groups')->insert([
            [
                'id'    => 1,
                'name'  => 'SuperAdmin',
                'description' => 'God'
            ]
        ]);

        DB::table('group_role')->insert([
            [
                'group_id' => 1,
                'role_id'  => 1,
            ],
            [
                'group_id' => 1,
                'role_id'  => 2,
            ],
            [
                'group_id' => 1,
                'role_id'  => 3,
            ],
            [
                'group_id' => 1,
                'role_id'  => 4,
            ],
            [
                'group_id' => 1,
                'role_id'  => 5,
            ],
            [
                'group_id' => 1,
                'role_id'  => 6,
            ],

        ]);

        DB::table('admin_group')->insert([
            [
                'admin_id'  => 1,
                'group_id' => 1
            ]
        ]);

    }
}
