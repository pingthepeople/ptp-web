<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegislatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Legislator', function (Blueprint $table) {
            $table->increments('id');
            $table->text('FirstName', 256);
            $table->text('LastName', 256);
            $table->text('Link', 256);
            $table->tinyInteger('Chamber');
            $table->tinyInteger('Party');
            $table->tinyInteger('District');
            $table->text('Image', 256);
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
        Schema::dropIfExists('Legislator');
    }
}
