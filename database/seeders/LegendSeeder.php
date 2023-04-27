<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Legend;
use App\Models\User;
use Illuminate\Database\Seeder;

class LegendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Global legends
        Legend::create([
            'title' => 'Available',
            'calendar_id' => null,
            'color' => '#86efac',
            'split_color' => null,
            'is_default' => true,
            'is_global' => true,
            'order' => 0,
            'organization_id' => User::where('email', 'superadmin@gmail.com')->first()->organization_id,
        ]);
        Legend::create([
            'title' => 'Available',
            'calendar_id' => null,
            'color' => '#86efac',
            'split_color' => null,
            'is_default' => true,
            'is_global' => true,
            'order' => 0,
            'organization_id' => User::where('email', 'superuser@gmail.com')->first()->organization_id,
        ]);

        Legend::create([
            'title' => 'Booked',
            'calendar_id' => null,
            'color' => '#fca5a5',
            'split_color' => null,
            'is_default' => false,
            'is_global' => true,
            'order' => 1,
            'organization_id' => User::where('email', 'superadmin@gmail.com')->first()->organization_id,
        ]);

        Legend::create([
            'title' => 'Booked',
            'calendar_id' => null,
            'color' => '#fca5a5',
            'split_color' => null,
            'is_default' => false,
            'is_global' => true,
            'order' => 1,
            'organization_id' => User::where('email', 'superuser@gmail.com')->first()->organization_id,
        ]);

        // Calendar legends
        Legend::create([
            'title' => 'Available',
            'calendar_id' => Calendar::where('slug', 'test-calendar')->first()->id,
            'color' => '#86efac',
            'split_color' => null,
            'is_default' => true,
            'is_global' => false,
            'order' => 0,
            'organization_id' => User::where('email', 'superadmin@gmail.com')->first()->organization_id,
        ]);

        Legend::create([
            'title' => 'Booked',
            'calendar_id' => Calendar::where('slug', 'test-calendar')->first()->id,
            'color' => '#fca5a5',
            'split_color' => null,
            'is_default' => false,
            'is_global' => false,
            'order' => 1,
            'organization_id' => User::where('email', 'superadmin@gmail.com')->first()->organization_id,
        ]);
    }
}
