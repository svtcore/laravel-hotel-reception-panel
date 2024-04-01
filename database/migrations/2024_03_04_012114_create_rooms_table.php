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
            $table->string('floor');
            $table->string('door_number');
            $table->enum('type', ['standart','comfort','premium','king']);
            $table->unsignedFloat('area');
            $table->unsignedInteger('room_amount');
            $table->unsignedInteger('bed_amount');
            $table->unsignedInteger('children_bed_amount');
            $table->unsignedFloat('price');
            $table->enum('status', ['busy', 'free', 'maintence', 'reserved']);
            $table->timestamps();
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
