<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Subject', function (Blueprint $table) {
            $table->increments('Id');
            $table->text('Name', 256);
            $table->text('Link', 256);
            $table->timestamp('Created')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('SessionId')->unsigned()->nullable();
            $table->foreign('SessionId')->references('Id')->on('Session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Subject');
    }
}
