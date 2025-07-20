<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('kostumers', function (Blueprint $table) {
            $table->string('no_telepon')->nullable()->after('nama');
            $table->text('alamat')->nullable()->after('no_telepon');
        });
    }

    public function down(): void {
        Schema::table('kostumers', function (Blueprint $table) {
            $table->dropColumn(['no_telepon', 'alamat']);
        });
    }
};
