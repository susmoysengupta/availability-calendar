<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legends', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('calendar_id')->nullable()
                ->constrained('calendars')
                ->cascadeOnDelete();
            $table->foreignId('organization_id')->nullable()
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->unique(['title', 'calendar_id', 'organization_id'], 'legends_title_calendar_id_organization_id_unique');
            $table->string('color');
            $table->string('split_color')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_global')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_synced')->default(false);
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('legends');
    }
};
