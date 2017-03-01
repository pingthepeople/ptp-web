<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BillSubject', function (Blueprint $table) {
            $table->increments('Id');
            $table->dateTime('Assigned')->nullable();
            $table->timestamp('Created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('BillId')->unsigned()->nullable();
            $table->foreign('BillId')->references('Id')->on('Bill');
            $table->integer('SubjectId')->unsigned()->nullable();
            $table->foreign('SubjectId')->references('Id')->on('Subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('BillSubject');
    }
}
