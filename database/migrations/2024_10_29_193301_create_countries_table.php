<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('official_name');
            $table->string('currencies_name')->nullable();
            $table->string('currencies_symbol', 10)->nullable();
            $table->string('region');
            $table->string('languages');
            $table->string('google_maps')->nullable();
            $table->string('open_street_maps')->nullable();
            $table->string('timezones')->nullable();
            $table->string('flag_svg')->nullable();
            $table->timestamps();
        });
        // Add User Country Relation
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->after('id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
