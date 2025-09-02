<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('inventori_id')->constrained('inventoris')->onDelete('cascade');
            $table->decimal('jumlah', 8, 2);
            $table->integer('harga_satuan');
            $table->decimal('subtotal', 12, 2);
            $table->integer('diskon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('penjualan_details');
    }
};
