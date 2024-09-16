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
        Schema::create('additional_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bridelpreorder_id');
            $table->unsignedBigInteger('package_id'); 
            $table->foreign('bridelpreorder_id')->references('id')->on('bridelpreorder')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_packages');
    }
};
