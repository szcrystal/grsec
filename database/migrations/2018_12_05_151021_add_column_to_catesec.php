<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToCatesec extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::table('category_seconds', function (Blueprint $table) {
        	$table->string('main_img')->after('slug')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('category_seconds', 'main_img')) {
            Schema::table('category_seconds', function (Blueprint $table) {
                $table->dropColumn('main_img');
            });
        }
    }
}
