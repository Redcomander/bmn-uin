<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('inputter_name')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('merk')->nullable();
            $table->string('tanggal_input')->nullable();
            $table->string('tanggal_keluar')->nullable();
            $table->string('tahun_pengadaan')->nullable();
            $table->string('sumber')->nullable();
            $table->string('status')->nullable();
            $table->string('foto')->nullable();
            $table->string('no_inventaris')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('kategori')->nullable();
            $table->string('barcode')->nullable();
            $table->string('posisi')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
