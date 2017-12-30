<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToLegislatorCommitteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('LegislatorCommittee', function (Blueprint $table) {
            $table->tinyInteger('Position')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('LegislatorCommittee', function (Blueprint $table) {
            $table->dropColumn('Position');
        });
    }
}
