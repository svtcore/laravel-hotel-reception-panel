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
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('adult_amount')->default(1);
            $table->unsignedInteger('children_amount')->default(0);
            $table->unsignedFloat('total_cost')->default(0);
            $table->enum('payment_type', ['credit_card', 'cash']);
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');
            $table->string('note')->nullable();
            $table->enum('status', ['reserved', 'canceled', 'active', 'expired', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
