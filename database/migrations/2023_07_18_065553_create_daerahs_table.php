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
        Schema::create('daerahs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kota_id');
            $table->string('nama_daerah');
            $table->timestamps();

            $table->foreign('kota_id')->references('id')->on('kotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daerahs');
    }
};
