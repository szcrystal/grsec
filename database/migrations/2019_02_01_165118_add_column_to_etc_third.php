<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEtcThird extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
        	$table->timestamp('cancel_date')->after('is_cancel')->nullable()->default(NULL);
        });
        
        Schema::table('sale_relations', function (Blueprint $table) {
        	$table->text('user_comment')->after('destination')->nullable()->default(NULL);
        });
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('sales', 'cancel_date')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('cancel_date');
            });
        }
        
        if (Schema::hasColumn('sale_relations', 'user_comment')) {
            Schema::table('sale_relations', function (Blueprint $table) {
                $table->dropColumn('user_comment');
            });
        }
        
    }
}
