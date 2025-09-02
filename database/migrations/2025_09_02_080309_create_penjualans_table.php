<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_id')->unique()->nullable();
            $table->date('tanggal_penjualan');
            $table->enum('metode_pembayaran', ['CASH','QRIS','TRANSFER']);
            $table->enum('status_pembayaran', ['PAID','UNPAID'])->default('UNPAID');
            $table->string('nama_kostumer')->nullable();
            $table->integer('total_harga');
            $table->timestamps();
            $table->foreignId('paid_by_user_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->date('tanggal_pelunasan')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('penjualans');
    }
};