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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom departemen_id
            $table->unsignedBigInteger('departemen_id')->nullable()->after('id');

            // Tambahkan foreign key yang mengacu ke departemens.id
            $table->foreign('departemen_id')
                ->references('id')
                ->on('departemens')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            // Drop foreign key dan kolomnya saat rollback
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
        });
    }
};
