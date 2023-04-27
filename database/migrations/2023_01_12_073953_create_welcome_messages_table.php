<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $languages = json_decode(Storage::disk('local')->get('languagesWithCountryCode.json'), true);

        Schema::create('welcome_messages', function (Blueprint $table) use ($languages) {
            $table->id();
            $table->foreignId('organization_id')
                ->constrained('users', 'organization_id')
                ->cascadeOnDelete();

            foreach ($languages as $language) {
                $table->longText($language['code'])->nullable();
            }

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('welcome_messages');
    }
};
