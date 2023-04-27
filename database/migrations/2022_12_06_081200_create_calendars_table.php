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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('organization_id')->nullable()
                ->constrained('users', 'id')
                ->cascadeOnDelete();
            $table->unique(['title', 'organization_id'], 'calendars_title_organization_id_unique');
            $table->boolean('should_include_details')->default(false);
            $table->string('hyperlink')->nullable();
            $table->string('image_url')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->json('ical_feeds')->nullable();
            $table->enum('ical_feed_book_type', ['all', 'any'])->default('any');
            $table->boolean('should_split')->default(false);
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
        Schema::dropIfExists('calendars');
    }
};
