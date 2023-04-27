<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $welcomeMessage = <<<EOT
        <p>Hi there, An account has been created for you on AvailabilityCalendar.com by :superuser.email.</p>

        <p>Your username: :user.email</p>

        <p>Activate your account and choose a safe, unique password by clicking on this link: :site.login_url</p>

        <p>If you have any questions, please contact :superuser.email.</p>
        EOT;

        AppSetting::query()->truncate();

        AppSetting::create([
            'key' => 'welcome_message',
            'value' => $welcomeMessage,
        ]);
    }
}
