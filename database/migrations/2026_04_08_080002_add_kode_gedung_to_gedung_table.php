<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gedung', function (Blueprint $table) {
            $table->string('kode_gedung')->nullable()->after('id_gedung');
        });
    }

    public function down(): void
    {
        Schema::table('gedung', function (Blueprint $table) {
            $table->dropColumn('kode_gedung');
        });
    }
};
