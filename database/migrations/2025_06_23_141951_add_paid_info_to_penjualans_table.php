<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->foreignId('paid_by_user_id')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('tanggal_pelunasan')->nullable();
    });
}

public function down()
{
    Schema::table('penjualans', function (Blueprint $table) {
        $table->dropForeign(['paid_by_user_id']);
        $table->dropColumn(['paid_by_user_id', 'tanggal_pelunasan']);
    });
}

};
