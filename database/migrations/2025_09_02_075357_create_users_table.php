<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('kode_user')->unique()->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin','kasir'])->default('kasir');
            $table->string('foto_profil')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('nama_lengkap', 22)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};
