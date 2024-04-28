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
        Schema::table('guests_bookings', function (Blueprint $table) {
            $table->foreign('guest_id')->references('id')->on('guests');
            $table->foreign('booking_id')->references('id')->on('bookings');

            $table->primary(['guest_id', 'booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests_bookings', function (Blueprint $table) {
            //
        });
    }
};
