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
        Schema::create('seat', function (Blueprint $table) {
            $table->id();
            $table->char('row', 1);
            $table->integer('seat_number');
            $table->enum('type', ['Standard', 'VIP', 'Couple']);
            $table->enum('status', ['Available', 'Sold', 'Selected'])->default('Available');
            $table->unsignedBigInteger('theater_id');
            $table->unsignedBigInteger('showtime_id');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('theater_id')->references('id')->on('theater')->onDelete('cascade');
            $table->foreign('showtime_id')->references('id')->on('showtime')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seat');
    }
};