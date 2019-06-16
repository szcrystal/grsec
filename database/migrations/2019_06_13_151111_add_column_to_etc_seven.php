<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcSeven extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //SaleRel
        Schema::table('sale_relations', function (Blueprint $table) {            
            $table->integer('total_price')->after('all_price')->nullable()->default(NULL);
            $table->integer('add_point')->after('use_point')->nullable()->default(0);
        });
        
        //Setting
        Schema::table('settings', function (Blueprint $table) {            
            $table->string('admin_forward_email')->after('admin_email')->nullable()->default(NULL);
        });
        
        //Sale
        Schema::table('sales', function (Blueprint $table) {            
            $table->integer('add_point')->after('use_point')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	//SaleRel
        if (Schema::hasColumn('sale_relations', 'total_price')) {
            Schema::table('sale_relations', function (Blueprint $table) {
                $table->dropColumn('total_price');
            });
        }
        
        if (Schema::hasColumn('sale_relations', 'add_point')) {
            Schema::table('sale_relations', function (Blueprint $table) {
                $table->dropColumn('add_point');
            });
        }
        
        //Setting
        if (Schema::hasColumn('settings', 'admin_forward_email')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('admin_forward_email');
            });
        }
        
        //Sale
        if (Schema::hasColumn('sales', 'add_point')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('add_point');
            });
        }
        
    }
}
