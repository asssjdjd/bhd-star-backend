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
        Schema::create('foodcombo', function (Blueprint $table) {
            $table->id();
            $table->string('theater_id')->nullable();
            $table->string('name')->nullable();
            $table->string('theater_name')->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('image')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foodcombo');
    }
};
