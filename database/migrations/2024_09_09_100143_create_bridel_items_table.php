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
        Schema::create('bridel_items', function (Blueprint $table) {
            $table->id();
            $table->string('Bridel_sub_category');
            $table->string('Item_name');
            $table->string('quentity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bridel_items');
    }
};
