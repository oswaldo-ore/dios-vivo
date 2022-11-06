<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBusinesessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->boolean('show_report_public')->default(false);
            $table->date('start_date_report_public')->nullable()->default(null);
            $table->date('end_date_report_public')->nullable()->default(null);
            $table->boolean('show_report_yearly')->default(false);
            $table->year('start_report_year')->nullable()->default(null);
            $table->date('date_close_show')->nullable()->default(null)->comment('closing date to show');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('show_report_public');
            $table->dropColumn('start_date_report_public');
            $table->dropColumn('end_date_report_public');
            $table->dropColumn('show_report_yearly');
            $table->dropColumn('start_report_year');
            $table->dropColumn('date_close_show');
        });
    }
}
