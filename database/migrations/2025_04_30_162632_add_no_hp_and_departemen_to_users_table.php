<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->nullable();
            $table->string('departemen')->nullable();
            $table->string('role')->default('pelapor');
            $table->string('status')->default('open');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_sap', 'no_hp', 'departemen', 'role']);
        });
    }
};
