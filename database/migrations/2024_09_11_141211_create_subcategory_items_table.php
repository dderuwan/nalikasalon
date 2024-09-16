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
        Schema::create('subcategory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bridelpreorder_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('item_id'); // Add item_id to link specific items

            $table->foreign('bridelpreorder_id')->references('id')->on('bridelpreorder')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('bridel_sub_category'); // Ensure the subcategories table exists
            $table->foreign('item_id')->references('id')->on('bridel_items'); // Ensure the items table exists
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategory_items');
    }
};
