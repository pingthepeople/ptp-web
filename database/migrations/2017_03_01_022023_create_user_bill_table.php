<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserBill', function (Blueprint $table) {
            $table->increments('Id');
            $table->boolean('ReceiveAlertEmail')->default(false);
            $table->boolean('ReceiveAlertSms')->default(false);
            $table->timestamp('Created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('BillId')->unsigned()->nullable();
            $table->foreign('BillId')->references('Id')->on('Bill');
            $table->integer('UserId')->unsigned()->nullable();
            $table->foreign('UserId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UserBill');
    }
}
