<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('admin_level', ['gedung', 'fakultas', 'super'])->nullable()->after('role');
            $table->unsignedBigInteger('id_gedung')->nullable()->after('admin_level');
            $table->foreign('id_gedung')->references('id_gedung')->on('gedung')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_gedung']);
            $table->dropColumn(['admin_level', 'id_gedung']);
        });
    }
};
