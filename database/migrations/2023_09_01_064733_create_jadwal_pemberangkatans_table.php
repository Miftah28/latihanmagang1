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
        Schema::create('jadwal_pemberangkatans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_daerah_id');
            $table->unsignedBigInteger('daerah_id');
            $table->string('keberangkatan');
            $table->string('tujuan');
            $table->date('tanggal_keberangkatan');
            $table->time('waktu');
            $table->text('alamat');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('daerah_id')->references('id')->on('daerahs')->onDelete('cascade');
            $table->foreign('admin_daerah_id')->references('id')->on('admin_daerahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_pemberangkatans');
    }
};
