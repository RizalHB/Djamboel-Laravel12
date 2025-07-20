<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('suppliers', function (Blueprint $table) {
        $table->string('kode_supplier')->unique()->nullable()->after('id');
    });

    Schema::table('kostumers', function (Blueprint $table) {
        $table->string('kode_kostumer')->unique()->nullable()->after('id');
    });

    Schema::table('inventoris', function (Blueprint $table) {
        $table->string('kode_barang')->unique()->nullable()->after('id');
    });

    Schema::table('penjualans', function (Blueprint $table) {
        $table->string('kode_transaksi')->unique()->nullable()->after('id');
    });

    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->string('kode_pengeluaran')->unique()->nullable()->after('id');
    });
}

public function down()
{
    Schema::table('suppliers', function (Blueprint $table) {
        $table->dropColumn('kode_supplier');
    });

    Schema::table('kostumers', function (Blueprint $table) {
        $table->dropColumn('kode_kostumer');
    });

    Schema::table('inventoris', function (Blueprint $table) {
        $table->dropColumn('kode_barang');
    });

    Schema::table('penjualans', function (Blueprint $table) {
        $table->dropColumn('kode_transaksi');
    });

    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->dropColumn('kode_pengeluaran');
    });
}

};
