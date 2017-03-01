<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BillCommittee', function (Blueprint $table) {
            $table->increments('Id');
            $table->dateTime('Assigned')->nullable();
            $table->timestamp('Created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('BillId')->unsigned()->nullable();
            $table->foreign('BillId')->references('Id')->on('Bill');
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
        Schema::dropIfExists('BillCommittee');
    }
}
