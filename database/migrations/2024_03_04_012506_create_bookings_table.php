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
            $table->unsignedInteger('adults_count')->default(1);
            $table->unsignedInteger('children_count')->default(0);
            $table->float('total_cost')->default(0)->unsigned();
            $table->enum('payment_type', ['credit_card', 'cash', 'discount']);
            $table->dateTime('check_in_date');
            $table->dateTime('check_out_date');
            $table->string('note')->nullable();
            $table->enum('status', ['reserved', 'cancelled', 'active', 'expired', 'completed']);
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
