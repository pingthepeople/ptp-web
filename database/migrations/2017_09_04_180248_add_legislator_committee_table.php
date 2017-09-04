<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegislatorCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LegislatorCommittee', function (Blueprint $table) {
            $table->increments('id');
            $table->date('Created')->useCurrent();
            $table->integer('LegislatorId')->unsigned()->nullable();
            $table->foreign('LegislatorId')->references('Id')->on('Legislator');
            $table->integer('CommitteeId')->unsigned()->nullable();
            $table->foreign('CommitteeId')->references('Id')->on('Committee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LegislatorCommittee');
    }
}
