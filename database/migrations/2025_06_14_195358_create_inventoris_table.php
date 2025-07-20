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
        Schema::create('inventoris', function (Blueprint $table) {
    $table->id();
    $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
    $table->string('nama_barang');
    $table->enum('unit', ['Kg', 'Ekor', 'Pcs']);
    $table->decimal('amount', 10, 2)->default(0); // stok bisa desimal
    $table->integer('price_per_unit');
    $table->integer('harga_jual');
    $table->date('tanggal_pembelian');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventoris');
    }
};
