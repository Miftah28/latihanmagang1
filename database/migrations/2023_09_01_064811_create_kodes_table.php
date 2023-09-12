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
        Schema::create('kodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_daerah_id');
            $table->unsignedBigInteger('jadwal_keberangkatan_id');
            $table->unsignedBigInteger('penumpang_id')->nullable();
            $table->unsignedBigInteger('supir_id')->nullable();
            $table->string('kode');
            $table->timestamps();

            $table->foreign('admin_daerah_id')->references('id')->on('admin_daerahs')->onDelete('cascade');
            $table->foreign('jadwal_keberangkatan_id')->references('id')->on('jadwal_pemberangkatans')->onDelete('cascade');
            $table->foreign('penumpang_id')->references('id')->on('penumpangs')->onDelete('cascade');
            $table->foreign('supir_id')->references('id')->on('supirs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kodes');
    }
};
