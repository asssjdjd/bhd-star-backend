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
        Schema::create('film', function (Blueprint $table) {
            $table->id();
            $table->string("video_link")->nullable();
            $table->string("images")->nullable();
            $table->string("name", 255)->nullable();
            $table->integer("duration")->nullable();
            $table->string("name_director", 255)->nullable();
            $table->date("launch_date")->nullable();
            $table->string("name_actor", 255)->nullable();
            $table->string("description")->nullable();
            $table->string("type")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film');
    }
};
