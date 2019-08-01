<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcEight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //SaleRel
        Schema::table('sales', function (Blueprint $table) {            
            $table->boolean('is_huzaioki')->after('plan_time')->nullable()->default(null);
            //$table->integer('add_point')->after('use_point')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sales', 'is_huzaioki')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('is_huzaioki');
            });
        }
    }
}
