<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // delivery_groups 送料表
    	Schema::table('delivery_groups', function (Blueprint $table) {
        	$table->string('table_name')->after('factor')->nullable()->default(NULL);
        });
        
        Schema::table('delivery_groups', function (Blueprint $table) {
        	$table->text('table_comment')->after('table_name')->nullable()->default(NULL);
        });
        
        
        Schema::table('sale_relations', function (Blueprint $table) {
        	$table->integer('agent_type')->after('craim')->nullable()->default(NULL);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('delivery_groups', 'table_name')) {
            Schema::table('delivery_groups', function (Blueprint $table) {
                $table->dropColumn('table_name');
            });
        }
        
        if (Schema::hasColumn('delivery_groups', 'table_comment')) {
            Schema::table('delivery_groups', function (Blueprint $table) {
                $table->dropColumn('table_comment');
            });
        }
        
        if (Schema::hasColumn('sale_relations', 'agent_type')) {
            Schema::table('sale_relations', function (Blueprint $table) {
                $table->dropColumn('agent_type');
            });
        }
        
        
        
    }
}
