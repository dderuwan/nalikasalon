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
        Schema::create('employee_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // Matches the type of 'id' in the employee table
            $table->date('date');
            $table->string('time_slot'); // e.g., '09:00-10:00'
            $table->timestamps();
    
            // Correct table name 'employee' in foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_availabilities');
    }
};
