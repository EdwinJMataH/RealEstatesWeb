<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles_modules', function (Blueprint $table) {
            $table->string('id_module', length: 25);
            $table->unsignedInteger('id_profile');
            $table->foreign('id_module')->references('id_module')->on('modules');
            $table->foreign('id_profile')->references('id_profile')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proile_modules');
    }
};
