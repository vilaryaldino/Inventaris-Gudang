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
        Schema::create('m_satuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_satuan_dasar');
            $table->string('kode_satuan', 20)->unique();
            $table->string('nama_satuan', 100);
            $table->decimal('konversi', 12, 4)->default(1);
            $table->timestamps();

            $table->foreign('id_satuan_dasar', 'fk_satuan_dasar')
                  ->references('id')
                  ->on('m_satuan_dasar')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_satuan');
    }
};
