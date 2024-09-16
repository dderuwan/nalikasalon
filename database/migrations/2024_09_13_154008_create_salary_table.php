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
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employee')->onDelete('cascade'); // Link to employee table
            $table->integer('year'); // Add year column
            $table->integer('month');
            $table->integer('days_of_work')->nullable();
            $table->integer('no_pay_days')->nullable();
            $table->decimal('no_pay_amount', 10, 2)->nullable();
            $table->decimal('salary', 10, 2);
            $table->decimal('allowance', 10, 2)->nullable();
            $table->decimal('epf_deduction', 10, 2)->nullable();
            $table->decimal('salary_advance_deduction', 10, 2)->nullable();
            $table->decimal('gross_salary', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary');
    }
};
