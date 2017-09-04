<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegislatorBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LegislatorBill', function (Blueprint $table) {
            $table->increments('Id');
            $table->date('Created')->useCurrent();
            $table->integer('LegislatorId')->unsigned()->nullable();
            $table->foreign('LegislatorId')->references('Id')->on('Legislator');
            $table->integer('BillId')->unsigned()->nullable();
            $table->foreign('BillId')->references('Id')->on('Bill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LegislatorBill');
    }
}
