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
        if (!Schema::hasColumn('gd_terima_beli_m', 'no_po')) {
            Schema::table('gd_terima_beli_m', function (Blueprint $table) {
                $table->string('no_po', 50)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('gd_terima_beli_m', 'no_po')) {
            Schema::table('gd_terima_beli_m', function (Blueprint $table) {
                $table->dropColumn('no_po');
            });
        }
    }
};

