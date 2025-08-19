<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            if (!Schema::hasColumn('laporans', 'catatan_selesai')) {
                $table->text('catatan_selesai')->nullable()->after('status');
            }

            if (!Schema::hasColumn('laporans', 'tampilkan_di_kb')) {
                $table->boolean('tampilkan_di_kb')->default(false)->after('catatan_selesai');
            }
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('catatan_selesai');
            $table->dropColumn('tampilkan_di_kb');
        });
    }
};
