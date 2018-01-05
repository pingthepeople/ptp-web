<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomStartToScheduledActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ScheduledAction', function (Blueprint $table) {
            $table->text('CustomStart')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ScheduledAction', function (Blueprint $table) {
            $table->dropColumn('CustomStart');
        });
    }
}
