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
            $table->timestamp('processed_at')->nullable()->after('created_at');
            $table->timestamp('closed_at')->nullable()->after('processed_at');
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['processed_at', 'closed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
};
