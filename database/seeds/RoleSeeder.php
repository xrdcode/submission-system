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
            ],
            [
                'id'    => 7,
                'name'  => 'EventManagement-Create',
                'description' => 'Group Management'
            ],
            [
                'id'    => 8,
                'name'  => 'EventManagement-View',
                'description' => 'Group Management'
            ],
            [
                'id'    => 9,
                'name'  => 'EventManagement-Save',
                'description' => 'Group Management'
            ],
            [
                'id'    => 10,
                'name'  => 'SubmissionManagement-MinimumSaveAccess',
                'description' => 'Submission Management'
            ],
            [
                'id'    => 11,
                'name'  => 'SubmissionManagement-View',
                'description' => 'Submission Management View'
            ],
            [
                'id'    => 12,
                'name'  => 'SubmissionManagement-Save',
                'description' => 'Submission Management'
            ],
            [
                'id'    => 13,
                'name'  => 'PaymentManagement-Save',
                'description' => 'Payment Management'
            ],
            [
                'id'    => 14,
                'name'  => 'PaymentManagement-View',
                'description' => 'Payment Management'
            ],
            [
                'id'    => 15,
                'name'  => 'PricingManagement-Save',
                'description' => 'Pricing Management'
            ],
            [
                'id'    => 16,
                'name'  => 'PricingManagement-Create',
                'description' => 'Pricing Management'
            ],
            [
                'id'    => 17,
                'name'  => 'PricingManagement-View',
                'description' => 'Pricing Management'
            ],
            [
                'id'    => 18,
                'name'  => 'ScheduleManagement-Save',
                'description' => 'Schedule Management'
            ],
            [
                'id'    => 19,
                'name'  => 'ScheduleManagement-Create',
                'description' => 'Schedule Management'
            ],
            [
                'id'    => 20,
                'name'  => 'ScheduleManagement-View',
                'description' => 'Schedule Management'
            ],
            [
                'id'    => 21,
                'name'  => 'MasterdataManagement-Create',
                'description' => 'Masterdata Management'
            ],
            [
                'id'    => 22,
                'name'  => 'MasterdataManagement-Save',
                'description' => 'Masterdata Management'
            ],
            [
                'id'    => 23,
                'name'  => 'MasterdataManagement-Update',
                'description' => 'Masterdata Management'
            ],
            [
                'id'    => 24,
                'name'  => 'AdminManagement-Create',
                'description' => 'Admin Management'
            ],
            [
                'id'    => 25,
                'name'  => 'AdminManagement-Save',
                'description' => 'Admin Management'
            ],
            [
                'id'    => 26,
                'name'  => 'AdminManagement-Update',
                'description' => 'Admin Management'
            ]
            ,
            [
                'id'    => 27,
                'name'  => 'PublicationManagement-MinimumSaveAccess',
                'description' => 'Publication Management'
            ],
            [
                'id'    => 28,
                'name'  => 'PublicationManagement-View',
                'description' => 'Publication Management View'
            ],
            [
                'id'    => 29,
                'name'  => 'PublicationManagement-Save',
                'description' => 'Publication Management'
            ]
        ]);

        DB::table('groups')->insert([
            [
                'id'    => 1,
                'name'  => 'SuperAdmin',
                'description' => 'God'
            ],
            [
                'id'    => 2,
                'name'  => 'Editor',
                'description'   => 'Editor'
            ],
            [
                'id'    => 3,
                'name'  => 'Reviewer',
                'description'   => 'Reviewer'
            ],
            [
                'id'    => 4,
                'name'  => 'Verificator',
                'description'   => 'Payment Verification'
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
            [
                'group_id' => 2,
                'role_id'  => 10,
            ],
            [
                'group_id' => 2,
                'role_id'  => 11,
            ],
            [
                'group_id' => 3,
                'role_id'  => 27,
            ],
            [
                'group_id' => 3,
                'role_id'  => 28,
            ],
            [
                'group_id' => 4,
                'role_id'  => 13,
            ],
            [
                'group_id' => 4,
                'role_id'  => 14,
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
