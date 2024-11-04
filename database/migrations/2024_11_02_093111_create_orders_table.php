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
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id'); 
            $table->string('pickup_location');
            $table->string('delivery_location');
            $table->decimal('size', 8, 2)->nullable(); // Allow null
            $table->decimal('weight', 8, 2)->nullable(); // Allow null
            $table->dateTime('pickup_datetime');
            $table->dateTime('delivery_datetime');
            $table->enum('status', ['Pending', 'In-Progress', 'Delivered'])->default('Pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
