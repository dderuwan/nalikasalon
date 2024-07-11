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
        Schema::create('gins', function (Blueprint $table) {
            $table->id();
            $table->string('gin_code')->unique();
            $table->string('order_request_code');
            $table->string('supplier_code');
            $table->date('date');
            $table->decimal('total_cost_payment', 15, 2);
            $table->timestamps();

            
            $table->foreign('order_request_code')->references('order_request_code')->on('order_requests')->onDelete('cascade');
            $table->foreign('supplier_code')->references('supplier_code')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gins');
    }
};
