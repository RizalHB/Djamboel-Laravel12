<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('inventori_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventori_id')->constrained('inventoris')->onDelete('cascade');
            $table->decimal('jumlah', 8, 2)->nullable();
            $table->integer('harga_satuan')->nullable();
            $table->date('tanggal')->default(DB::raw('current_timestamp()'));
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('inventori_pengeluarans');
    }
};
