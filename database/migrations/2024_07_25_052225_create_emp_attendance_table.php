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
        Schema::create('emp_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id');
            $table->date('date');
            $table->string('sign_in')->nullable(); 
            $table->string('sign_out')->nullable();
            $table->string('stayed_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_attendance');
    }
};
