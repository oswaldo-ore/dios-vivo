<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('close_boxes', function (Blueprint $table) {
            $table->id();
            $table->year('year')->default('1990');
            $table->double('total_haber',20,2)->default(0);
            $table->double('total_debe',20,2)->default(0);
            $table->double('total_saldo',20,2)->default(0);
            $table->string('description')->default('');
            $table->softDeletes();
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
        Schema::dropIfExists('close_boxes');
    }
}
