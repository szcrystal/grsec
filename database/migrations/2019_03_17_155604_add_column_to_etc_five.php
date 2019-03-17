<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	//Contact add
        Schema::table('contacts', function (Blueprint $table) {
        	$table->string('tel_num')->after('ask_category')->nullable()->default(NULL);
            $table->string('request_day')->after('tel_num')->nullable()->default(NULL);
            $table->string('request_time')->after('request_day')->nullable()->default(NULL);
            $table->integer('is_ask_type')->after('comment')->nullable()->default(NULL); //booleanではなくintにしている
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('contacts', 'tel_num')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('tel_num');
            });
        }
        
        if (Schema::hasColumn('contacts', 'request_day')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('request_day');
            });
        }
        
        if (Schema::hasColumn('contacts', 'request_time')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('request_time');
            });
        }
        
        if (Schema::hasColumn('contacts', 'is_ask_type')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropColumn('is_ask_type');
            });
        }
    }
}
