<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLegislatorBillCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('LegislatorBill', function (Blueprint $table) {
            $table->renameColumn('BillPosition', 'Position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('LegislatorBill', function (Blueprint $table) {
            $table->renameColumn('Position', 'BillPosition');
        });
    }
}
