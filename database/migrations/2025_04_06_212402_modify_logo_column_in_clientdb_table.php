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
        Schema::table('clientdb', function (Blueprint $table) {
            $table->string('logo')->nullable()->change(); // Ensure the logo column is a nullable string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientdb', function (Blueprint $table) {
            $table->string('logo')->nullable(false)->change(); // Revert to non-nullable if needed
        });
    }
};
