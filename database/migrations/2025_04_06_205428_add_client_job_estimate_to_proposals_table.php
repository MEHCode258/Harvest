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
        Schema::table('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('id'); // Foreign key to clients table
            $table->unsignedBigInteger('job_id')->nullable()->after('client_id'); // Foreign key to jobs table
            $table->decimal('estimate', 10, 2)->nullable()->after('price'); // Estimate column

            // Add foreign key constraints (optional)
            $table->foreign('client_id')->references('id')->on('clientdb')->onDelete('set null');
            $table->foreign('job_id')->references('id')->on('jobdb')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropForeign(['job_id']);
            $table->dropColumn(['client_id', 'job_id', 'estimate']);
        });
    }
};
