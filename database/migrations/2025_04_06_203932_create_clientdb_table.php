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
        Schema::create('clientdb', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Client name
            $table->string('email')->unique()->nullable(); // Email address
            $table->string('phone')->nullable(); // Phone number
            $table->string('add1')->nullable(); // Address line 1
            $table->string('add2')->nullable(); // Address line 2
            $table->string('city')->nullable(); // City
            $table->string('state')->nullable(); // State
            $table->string('zip')->nullable(); // ZIP code
            $table->string('website')->nullable(); // Website URL
            $table->string('logo')->nullable(); // Logo file path
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientdb');
    }
};
