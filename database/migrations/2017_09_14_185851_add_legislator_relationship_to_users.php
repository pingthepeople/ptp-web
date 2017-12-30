<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLegislatorRelationshipToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('RepresentativeId')->unsigned()->nullable();
            $table->foreign('RepresentativeId')->references('Id')->on('Legislator');
            $table->integer('SenatorId')->unsigned()->nullable();
            $table->foreign('SenatorId')->references('Id')->on('Legislator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_representativeid_foreign');
            $table->dropForeign('users_senatorid_foreign');
            $table->dropColumn('RepresentativeId');
            $table->dropColumn('SenatorId');
        });
    }
}
