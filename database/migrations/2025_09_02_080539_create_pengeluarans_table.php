<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pengeluaran')->unique();
            $table->string('nama_pengeluaran');
            $table->integer('kuantitas');
            $table->integer('harga_satuan');
            $table->integer('total_harga');
            $table->string('kategori');
            $table->string('kategori_lainnya')->nullable();
            $table->date('tanggal_pengeluaran');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengeluarans');
    }
};
