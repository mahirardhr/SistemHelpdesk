<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('category');
            $table->string('department')->nullable();
            $table->text('description');
            $table->string('status')->default('open'); // ✅ Default: open
            $table->string('reporter_name');
            $table->string('attachment')->nullable();
            $table->string('catatan_selesai')->nullable();
            $table->boolean('tampilkan_di_kb')->default(false);
            $table->unsignedBigInteger('kategori_id')->nullable();
            $table->unsignedBigInteger('pelapor_id')->nullable();
            $table->unsignedBigInteger('pic_id')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->nullable();
            $table->date('sla_close')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
