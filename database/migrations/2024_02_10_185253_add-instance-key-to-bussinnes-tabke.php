<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstanceKeyToBussinnesTabke extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->string('whatsapp_instance',11)->unique()->default('')->after('id');
            $table->boolean('state_connection')->default(false)->comment('false no connected, true connected')->after('whatsapp_instance');
            $table->string('phone_number_connected')->default('')->after('state_connection');
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
            $table->dropColumn('whatsapp_instance');
            $table->dropColumn('state_connection');
            $table->dropColumn('phone_number_connected');
        });
    }
}
