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
        Schema::create('inventori_pengeluarans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('inventori_id')->constrained()->onDelete('cascade');
    $table->integer('jumlah');
    $table->integer('harga_satuan');
    $table->date('tanggal');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventori_pengeluarans');
    }
};
