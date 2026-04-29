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
    Schema::create('detail_peminjaman', function (Blueprint $table) {

    $table->unsignedBigInteger('id_peminjaman');
    $table->unsignedBigInteger('id_ruangan');

    $table->foreign('id_peminjaman')
          ->references('id_peminjaman')
          ->on('peminjaman');

    $table->foreign('id_ruangan')
          ->references('id_ruangan')
          ->on('ruangan');

    $table->primary(['id_peminjaman', 'id_ruangan']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamen');
    }
};
