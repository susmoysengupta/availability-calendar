<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = json_decode(Storage::get('languagesWithCountryCode.json'), true);

        Language::query()->delete();
        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
