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
        Schema::create('penjualan_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('penjualan_id')->constrained()->onDelete('cascade');
    $table->foreignId('inventori_id')->constrained()->onDelete('cascade');
    $table->integer('jumlah');
    $table->integer('harga_satuan');
    $table->integer('subtotal');
    $table->integer('diskon')->nullable(); // persentase diskon per item
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
    }
};
