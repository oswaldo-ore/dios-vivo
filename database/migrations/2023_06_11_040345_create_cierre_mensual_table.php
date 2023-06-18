<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierreMensualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_closure', function (Blueprint $table) {
            $table->id();
            $table->double('total_haber')->default(0);
            $table->double('total_debe')->default(0);
            $table->double('total_debe_haber')->default(0);
            $table->double('total_anterior')->default(0);
            $table->double('total_cierre')->default(0);
            $table->string('description')->default();
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('monthly_closure');
    }
}
