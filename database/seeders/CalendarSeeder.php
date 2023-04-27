<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Seeder;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Calendar::create([
            'title' => 'Test Calendar',
            'organization_id' => User::where('email', 'superadmin@gmail.com')->first()->organization_id,
            'hyperlink' => 'https://www.google.com',
            'image_url' => 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
            'description' => 'This is a test calendar.',
        ]);
    }
}
