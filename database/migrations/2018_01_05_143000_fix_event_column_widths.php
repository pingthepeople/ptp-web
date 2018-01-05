<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEventColumnWidths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ScheduledAction', function (Blueprint $table) {
            $table->text('Start',16)->nullable()->change();
            $table->text('End',16)->nullable()->change();
            $table->text('CustomStart',256)->nullable()->change();
            $table->text('CommitteeLink',256)->nullable()->change();
        });
        Schema::table('Action', function (Blueprint $table) {
            $table->text('CommitteeLink',256)->nullable()->change();
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
            $table->text('Start')->nullable()->change();
            $table->text('End')->nullable()->change();
            $table->text('CustomStart')->nullable()->change();
            $table->text('CommitteeLink')->nullable()->change();
        });
        Schema::table('Action', function (Blueprint $table) {
            $table->text('CommitteeLink')->nullable()->change();
        });
    }
}
