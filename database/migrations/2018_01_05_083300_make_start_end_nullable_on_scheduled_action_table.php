<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeStartEndNullableOnScheduledActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ScheduledAction', function (Blueprint $table) {
            $table->text('Start')->nullable()->change();
            $table->text('End')->nullable()->change();
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
            $table->text('Start')->change();
            $table->text('End')->change();
        });
    }
}
