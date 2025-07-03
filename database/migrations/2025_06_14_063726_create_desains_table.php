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
        Schema::create('desains', function (Blueprint $table) {
            $table->id();
            $table->string('gambar');
            $table->string('nama_produk');
            $table->string('nama_desainer');
            $table->integer('harga');
            $table->string('ukuran_lahan');
            $table->integer('lantai');
            $table->double('luas_tanah');
            $table->integer('kamar_tidur');
            $table->double('luas_bangunan');
            $table->integer('kamar_mandi');
            $table->string('gaya_desain');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desains');
    }
};
