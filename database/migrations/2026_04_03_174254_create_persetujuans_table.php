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
    Schema::create('persetujuan', function (Blueprint $table) {
    $table->id('id_persetujuan');
    $table->foreignId('id_peminjaman');
    $table->foreignId('id_ruangan');
    $table->foreignId('id_admin')->constrained('users');
    $table->enum('level_admin', ['gedung', 'fakultas', 'super']);
    $table->enum('status', ['pending', 'approved', 'rejected']);
    $table->dateTime('waktu_persetujuan')->nullable();
    $table->text('komentar')->nullable();
    $table->foreign(['id_peminjaman', 'id_ruangan'])
          ->references(['id_peminjaman', 'id_ruangan'])
          ->on('detail_peminjaman');

    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuans');
    }
};
