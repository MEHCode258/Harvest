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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('estimate_type')->nullable();
            $table->string('billable_rate_type')->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->decimal('fixed_fee', 10, 2)->nullable();
            $table->string('budget_type')->nullable();
            $table->decimal('budget_amount', 10, 2)->nullable();
            $table->string('budget_reset')->nullable();
            $table->integer('alert_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
