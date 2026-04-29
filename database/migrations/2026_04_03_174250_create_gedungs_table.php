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
    Schema::create('gedung', function (Blueprint $table) {
    $table->id('id_gedung');
    $table->unsignedBigInteger('id_cabang');
    $table->unsignedBigInteger('id_fakultas')->nullable();
    $table->foreign('id_cabang')->references('id_cabang')->on('cabang');
    $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
    $table->string('nama_gedung');
    $table->integer('jumlah_lantai');
    $table->enum('kategori', ['umum', 'fakultas']);
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gedungs');
    }
};
