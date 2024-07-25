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
        Schema::create('leave_apply', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('employee_id');
            $table->string('leave_type_id');
            $table->date('apply_strt_date');
            $table->date('apply_end_date');
            $table->integer('apply_day')->nullable();
            $table->date('leave_aprv_strt_date')->nullable();
            $table->date('leave_aprv_end_date')->nullable();
            $table->integer('num_aprv_day')->nullable();
            $table->string('reason')->nullable();
            $table->binary('apply_hard_copy')->nullable();
            $table->date('apply_date')->nullable();
            $table->date('approve_date')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_apply');
    }
};
