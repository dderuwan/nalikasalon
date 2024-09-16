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
        Schema::create('gin_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gin_id')->constrained('gins')->onDelete('cascade');
            $table->string('item_name');
            $table->string('packsize');
            $table->decimal('unit_price', 15, 2);
            $table->integer('in_quantity');
            $table->integer('shots_Count');
            $table->date('manufacture_date');
            $table->date('expire_date');
            $table->decimal('total_cost', 15, 2);
            $table->string('payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gin_items');
    }
};
