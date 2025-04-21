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
            $table->string('email')->unique()->nullable()->after('name'); // Add email column
            $table->string('phone')->nullable()->after('email'); // Add phone column
            $table->string('add1')->nullable()->after('phone'); // Add address line 1
            $table->string('add2')->nullable()->after('add1'); // Add address line 2
            $table->string('city')->nullable()->after('add2'); // Add city
            $table->string('state')->nullable()->after('city'); // Add state
            $table->string('zip')->nullable()->after('state'); // Add zip code
            $table->string('website')->nullable()->after('zip'); // Add website
            $table->string('logo')->nullable()->after('website'); // Add logo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientdb', function (Blueprint $table) {
            $table->dropColumn(['email', 'phone', 'add1', 'add2', 'city', 'state', 'zip', 'website', 'logo']);
        });
    }
};
