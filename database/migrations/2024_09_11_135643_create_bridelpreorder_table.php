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
        Schema::create('bridelpreorder', function (Blueprint $table) {
            $table->id();
            $table->string('Auto_serial_number')->unique();
            $table->string('contact_number_1');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('service_id');
            $table->string('package_id');
            $table->date('today');
            $table->date('Appoinment_date');
            $table->string('Appointment_time');
            $table->text('note')->nullable();
            $table->string('photographer_name')->nullable();
            $table->string('photographer_contact')->nullable();
            $table->string('Main_Dresser')->nullable();
            $table->string('Assistent_Dresser_1')->nullable();
            $table->string('Assistent_Dresser_2')->nullable();
            $table->string('Assistent_Dresser_3')->nullable();
            $table->boolean('hotel_dress')->default(0)->nullable();
            $table->decimal('Transport', 10, 2)->nullable();
            $table->decimal('Discount', 10, 2)->nullable();
            $table->string('payment_method');
            $table->string('Gift_vouchwe_id')->nullable();
            $table->decimal('Gift_voucher_value', 10, 2)->nullable();
            $table->string('promotion_id')->nullable();
            $table->decimal('Promotiona_value', 10, 2)->nullable();
            $table->decimal('advanced_payment', 10, 2);
            $table->decimal('Balance_Payment', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->string('status')->nullable()->default('not complete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bridelpreorder');
    }
};
