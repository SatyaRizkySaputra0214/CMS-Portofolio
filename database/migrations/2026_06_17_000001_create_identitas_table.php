<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identitas', function (Blueprint $table) {
            $table->integer('id')->primary()->default(1);
            $table->string('nama_lengkap', 100);
            $table->string('profesi', 100);
            $table->text('tentang_saya')->nullable();
            $table->string('foto_profil', 255)->nullable();
            $table->string('cv_file', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identitas');
    }
};
