<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id();
            $table->string('judul_proyek', 150);
            $table->string('thumbnail', 255)->nullable();
            $table->string('deskripsi_singkat', 255);
            $table->text('deskripsi_lengkap')->nullable();
            $table->string('link_eksternal', 255)->nullable();
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
