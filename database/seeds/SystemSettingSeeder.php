<?php

use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_settings')->insert([
            [
                "name" => "default_workstate",
                "value" => 1
            ],
            [
                "name" => "default_submission_status",
                "value" => 2
            ],
            [
                "name" => "app_name",
                "value" => "XC Submission System"
            ],
            [
                "name" => "app_link",
                "value" => "http://ssmath.dev/"
            ],
            [
                "name" => "smtp_setting_email",
                "value" => ""
            ],
            [
                "name" => "smtp_setting_port",
                "value" => ""
            ],
            [
                "name" => "smtp_setting_encryption",
                "value" => ""
            ],[
                "name" => "smtp_setting_password",
                "value" => ""
            ],[
                "name" => "default_flashmessage_class",
                "value" => ""
            ],
            [
                "name" => "default_message_types",
                "value" => ""
            ],
        ]);
    }
}
