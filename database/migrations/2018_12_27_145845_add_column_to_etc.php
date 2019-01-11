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
        
        Schema::table('sale_relations', function (Blueprint $table) {
        	$table->text('information_foot')->after('information')->nullable()->default(NULL);
        });
        
        Schema::table('send_mail_flags', function (Blueprint $table) {
        	$table->text('information_foot')->after('information')->nullable()->default(NULL);
        });
        
        
        Schema::table('sales', function (Blueprint $table) {
        	$table->boolean('is_keep')->after('deli_done')->nullable()->default(0);
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
        
        if (Schema::hasColumn('sale_relations', 'information_foot')) {
            Schema::table('sale_relations', function (Blueprint $table) {
                $table->dropColumn('information_foot');
            });
        }
        
        if (Schema::hasColumn('send_mail_flags', 'information_foot')) {
            Schema::table('send_mail_flags', function (Blueprint $table) {
                $table->dropColumn('information_foot');
            });
        }
        
        if (Schema::hasColumn('sales', 'is_keep')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('is_keep');
            });
        }
        
    }
}
