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
    Schema::create('ruangan', function (Blueprint $table) {
    $table->id('id_ruangan'); // 🔥 HARUS INI

    $table->unsignedBigInteger('id_gedung');
    $table->foreign('id_gedung')
          ->references('id_gedung')
          ->on('gedung');

    $table->string('nomor_ruangan');
    $table->string('nama_ruangan');
    $table->integer('kapasitas');
    $table->text('fasilitas');
    $table->integer('lantai');
    $table->string('tipe_ruangan');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangans');
    }
};
