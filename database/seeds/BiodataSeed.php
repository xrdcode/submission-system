<?php

use Illuminate\Database\Seeder;

use App\Models\BaseModel\User;
use App\Models\BaseModel\Biodata;

class BiodataSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        if(!empty($user)) {
            if(empty($user->biodatas)) {
                $biodata = new Biodata();
                $biodata->nik = '36720118582';
                $biodata->identity_number = '3145136217';
                $biodata->identity_type_id = 2;
                $user->biodatas()->save($biodata);
            }
        }
    }
}
