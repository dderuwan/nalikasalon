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
        Schema::create('gift_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('gift_voucher_Id');
            $table->string('gift_voucher_name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2); 
            $table->date('start_date'); 
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_voucher');
    }
};