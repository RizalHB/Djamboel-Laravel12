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
        Schema::create('penjualans', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal_penjualan');
    $table->enum('metode_pembayaran', ['CASH', 'QRIS', 'TRANSFER']);
    $table->enum('status_pembayaran', ['paid', 'unpaid'])->default('unpaid');
    $table->foreignId('kostumer_id')->nullable()->constrained('kostumers')->onDelete('set null');
    $table->string('nama_kostumer')->nullable(); // untuk non-vendor
    $table->integer('total_harga');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
