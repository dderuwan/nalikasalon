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
        Schema::create('real_time_booking', function (Blueprint $table) {
            $table->id();
            $table->string('real_time_app_no')->unique();
            $table->string('customer_code');
            $table->string('customer_name');
            $table->string('customer_contact_1');
            $table->string('customer_address');
            $table->date('customer_dob');
            $table->string('Service_type');
            $table->string('Package_name_1');
            $table->string('Package_name_2')->nullable();
            $table->string('Package_name_3')->nullable();
            $table->date('today');
            $table->string('appointment_time');
            $table->string('main_job_holder');
            $table->string('Assistant_1')->nullable();
            $table->string('Assistant_2')->nullable();
            $table->string('Assistant_3')->nullable();
            $table->text('note')->nullable();
            $table->string('preorder_id')->nullable();
            $table->decimal('Advanced_price',10,2)->nullable();
            $table->string('payment_type');
            $table->string('gift_voucher_No')->nullable();
            $table->decimal('gift_voucher_price',10,2)->nullable();
            $table->string('promotional_code_No')->nullable();
            $table->decimal('promotional_price',10,2)->nullable();
            $table->decimal('Total discount',10,2)->nullable();
            $table->decimal('vat',10,2)->nullable();
            $table->decimal('Total_price',10,2); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_time_booking');
    }
};
