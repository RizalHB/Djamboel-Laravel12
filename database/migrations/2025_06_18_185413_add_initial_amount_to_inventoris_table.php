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
        $table->float('initial_amount')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventoris', function (Blueprint $table) {
            //
        });
    }
};
