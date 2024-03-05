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
        Schema::create('rooms_room_properties', function (Blueprint $table) {
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('room_property_id');

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('room_property_id')->references('id')->on('room_properties');

            $table->primary(['room_id', 'room_property_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_room_properties');
    }
};
