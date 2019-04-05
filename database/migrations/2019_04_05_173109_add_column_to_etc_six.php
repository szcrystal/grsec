<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Item
        Schema::table('items', function (Blueprint $table) {            
            $table->string('pot_sort')->after('catchcopy')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('items', 'pot_sort')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn('pot_sort');
            });
        }
    }
}
