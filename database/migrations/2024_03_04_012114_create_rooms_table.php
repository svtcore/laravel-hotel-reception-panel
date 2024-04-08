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
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('floor_number');
            $table->string('room_number');
            $table->enum('type', ['standard', 'deluxe', 'suite', 'penthouse']);
            $table->unsignedInteger('total_rooms');
            $table->unsignedInteger('adults_beds_count');
            $table->unsignedInteger('children_beds_count');
            $table->unsignedFloat('price');
            $table->enum('status', ['occupied', 'available', 'under_maintenance']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
