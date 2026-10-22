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
        Schema::create('m_item', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 150);
            $table->unsignedBigInteger('id_satuan');
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_satuan', 'fk_item_satuan')
                  ->references('id')
                  ->on('m_satuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_item');
    }
};
