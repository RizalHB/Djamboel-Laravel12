<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventoris', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique()->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('nama_barang');
            $table->enum('unit', ['Kg','Ekor','Pcs']);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->integer('price_per_unit');
            $table->integer('harga_jual');
            $table->date('tanggal_pembelian');
            $table->timestamps();
            $table->double('initial_amount')->default(0);
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventoris');
    }
};
