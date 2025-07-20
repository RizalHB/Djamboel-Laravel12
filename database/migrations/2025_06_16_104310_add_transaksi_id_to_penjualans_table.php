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
    Schema::table('penjualans', function (Blueprint $table) {
        $table->string('transaksi_id')->nullable()->unique()->after('id');
    });
}

public function down()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->dropColumn('transaksi_id');
    });
}
};
