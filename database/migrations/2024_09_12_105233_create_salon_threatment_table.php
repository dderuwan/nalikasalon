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
        Schema::create('salon_threatment', function (Blueprint $table) {
            $table->id();
            $table->string('Booking_number')->unique();
            $table->string('contact_number_1');
            $table->string('customer_id');
            $table->string('customer_name');
            $table->string('service_id');
            $table->string('package_id');
            $table->date('today');
            $table->date('Appoinment_date')->nullable();
            $table->string('Appointment_time')->nullable();
            $table->text('note')->nullable();
            $table->string('Main_Dresser')->nullable();
            $table->string('Assistent_Dresser_1')->nullable();
            $table->string('Assistent_Dresser_2')->nullable();
            $table->string('Assistent_Dresser_3')->nullable();
            $table->decimal('Discount', 10, 2)->nullable();
            $table->string('payment_method');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salon_threatment');
    }
};
