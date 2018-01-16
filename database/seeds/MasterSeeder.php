<?php

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('identity_types')->insert([
            [
                'name'          => 'PASPOR',
                'description'   => 'Paspor'
            ],
            [
                'name'          => 'NIDN',
                'description'   => 'Nomor Induk Dosen Nasional'
            ],
            [
                'name'          => 'NIM',
                'description'   => 'Nomor Induk Mahasiswa'
            ],
            [
                'name'          => 'NO SIM',
                'description'   => 'Nomor SIM'
            ]
        ]);

        DB::table('pricing_types')->insert([
            [
                'name'          => 'Workshop',
                'description'   => 'Workshop only'
            ],
            [
                'name'          => 'Speakers',
                'description'   => 'Speakers only'
            ],
            [
                'name'          => 'Seminar',
                'description'   => 'Seminar only'
            ],
            [
                'name'          => 'Full',
                'description'   => 'Speakers, Workshop & Seminar '
            ],
        ]);

        DB::table('workstate_types')->insert([
            [
                'id'            => 1,
                'name'          => 'Submissions',
                'description'   => 'Submission State'
            ],
            [
                'id'            => 2,
                'name'          => 'Payments',
                'description'   => 'Payment state'
            ]
        ]);

        //DO NOT CHANGE ORDER
        DB::table('workstates')->insert([
            [
                'name'          => 'Abstract Review',
                'description'   => 'Abstract submitted to reviewer',
                'workstate_type_id'  => 1,
                'order'         => 1,
                'lock'          => 0
            ],
            [
                'name'          => 'Waiting Transfer Confirmation',
                'description'   => 'Next step if abstract approved. Please confirm transaction.',
                'workstate_type_id'  => 1,
                'order'         => 2,
                'lock'          => 0
            ],
            [
                'name'          => 'Waiting Full Paper',
                'description'   => 'Next step if abstract approved',
                'workstate_type_id'  => 1,
                'order'         => 3,
                'lock'          => 0
            ],
            [
                'name'          => 'Full Paper Review',
                'description'   => 'Next step if abstract approved',
                'workstate_type_id'  => 1,
                'order'         => 4,
                'lock'          => 0
            ],
            [
                'name'          => 'Full Paper Need Revision',
                'description'   => 'Paper Submitted to reviewer',
                'workstate_type_id'  => 1,
                'order'         => 5,
                'lock'          => 0
            ],
            [
                'name'          => 'Full Paper Approved',
                'description'   => 'Full Paper Approved',
                'workstate_type_id'  => 1,
                'order'         => 6,
                'lock'          => 0
            ],
            [
                'name'          => 'Rejected',
                'description'   => 'Rejected',
                'workstate_type_id'  => 1,
                'order'         => 0,
                'lock'          => 1
            ]
        ]);

        DB::table('submission_types')->insert([
            [
                'name'  => 'Oral Presenter',
                'description'  => 'Oral Presenter',
            ],
            [
                'name'  => 'Poster Presenter',
                'description'  => 'Poster Presenter',
            ],
        ]);
    }
}
