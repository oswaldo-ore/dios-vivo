<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description')->default('');
            $table->bigInteger('user_id')->unsigned();
            $table->date('date')->default('2000-01-01');
            $table->double('amount',8,2);
            $table->bigInteger('book_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('book_id')->on('books')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
