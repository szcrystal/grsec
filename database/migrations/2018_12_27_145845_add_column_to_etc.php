<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //adminsにpermissionのカラム追加
    	Schema::table('admins', function (Blueprint $table) {
        	$table->integer('permission')->after('email')->nullable()->default(NULL);
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         if (Schema::hasColumn('admins', 'permission')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('permission');
            });
        }
    }
}
