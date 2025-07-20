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
        $table->dropForeign(['kostumer_id']); // jika ada foreign key
        $table->dropColumn('kostumer_id');
        $table->string('transaksi_id')->unique()->nullable()->after('id');
    });
}

public function down()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->dropColumn('transaksi_id');
        $table->unsignedBigInteger('kostumer_id')->nullable();
        // $table->foreign('kostumer_id')->references('id')->on('kostumers')->nullOnDelete();
    });
}
};
