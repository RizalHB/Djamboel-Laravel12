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
    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->string('kode_pengeluaran')->unique()->after('id');
    });
}

public function down()
{
    Schema::table('pengeluarans', function (Blueprint $table) {
        $table->dropColumn('kode_pengeluaran');
    });
}
};
