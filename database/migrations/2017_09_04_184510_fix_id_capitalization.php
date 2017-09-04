<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixIdCapitalization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Legislator', function (Blueprint $table) {
            $table->renameColumn('id', 'Id');
        });

        Schema::table('LegislatorCommittee', function (Blueprint $table) {
            $table->renameColumn('id', 'Id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Legislator', function (Blueprint $table) {
            $table->renameColumn('Id', 'id');
        });
        Schema::table('LegislatorCommittee', function (Blueprint $table) {
            $table->renameColumn('Id', 'id');
        });
    }
}
