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
    Schema::table('inventoris', function (Blueprint $table) {
        $table->string('kode_barang')->nullable()->after('id')->unique();
    });
}

public function down()
{
    Schema::table('inventoris', function (Blueprint $table) {
        $table->dropColumn('kode_barang');
    });
}
};
