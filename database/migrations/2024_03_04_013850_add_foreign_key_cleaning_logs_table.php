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
        Schema::table('cleaning_logs', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms')->onUpdate('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cleaning_logs', function (Blueprint $table) {
            //
        });
    }
};
