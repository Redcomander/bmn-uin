<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAggregatedDataTable extends Migration
{
    public function up()
    {
        Schema::create('aggregated_data', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('aggregated_data');
    }
};

