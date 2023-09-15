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
        Schema::create('kursis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_pemberangkatan_id');
            $table->unsignedBigInteger('pemesanan_id');
            $table->unsignedBigInteger('penumpang_id');
            $table->integer('nomor_kursi');
            $table->string('status_kursi')->default('kosong');
            $table->timestamps();

            $table->foreign('jadwal_pemberangkatan_id')->references('id')->on('jadwal_pemberangkatans')->onDelete('cascade');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanans')->onDelete('cascade');
            $table->foreign('penumpang_id')->references('id')->on('penumpangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursis');
    }
};
