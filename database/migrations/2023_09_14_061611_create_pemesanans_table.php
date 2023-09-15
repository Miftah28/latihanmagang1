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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_pemberangkatan_id');
            $table->unsignedBigInteger('supir_id')->nullable();
            $table->unsignedBigInteger('penumpang_id')->nullable();
            $table->integer('tempat_duduk');
            $table->string('status_pembayaran')->default('prosess');
            $table->string('status_sampai_tujuan')->default('menunggu supir');
            $table->timestamps();

            $table->foreign('jadwal_pemberangkatan_id')->references('id')->on('jadwal_pemberangkatans')->onDelete('cascade');
            $table->foreign('supir_id')->references('id')->on('supirs')->onDelete('cascade');
            $table->foreign('penumpang_id')->references('id')->on('penumpangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
