<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('reporter_name');
        });
    }

    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('reporter_name')->nullable(); // buat rollback kalau perlu
        });
    }
};
