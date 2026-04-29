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
        Schema::create('peminjaman', function (Blueprint $table) {
        $table->id('id_peminjaman');
        $table->foreignId('id_user')->constrained('users');
        $table->dateTime('waktu_mulai');
        $table->dateTime('waktu_selesai');
        $table->text('tujuan');
        $table->dateTime('waktu_pengajuan');
        $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled']);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
