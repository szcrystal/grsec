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
        
        
        //users gmo関連のカラム
        Schema::table('users', function (Blueprint $table) {
        	$table->string('member_id')->after('remember_token')->nullable()->default(NULL);
        });
        
        Schema::table('users', function (Blueprint $table) {
        	$table->timestamp('member_regist_date')->after('member_id')->nullable()->default(NULL);
        });
        
        Schema::table('users', function (Blueprint $table) {
        	$table->integer('card_regist_count')->after('member_regist_date')->nullable()->default(0);
        });
        
        
        //User NoRegistの関連カラム
        Schema::table('user_noregists', function (Blueprint $table) {
        	$table->string('member_id')->after('active')->nullable()->default(NULL);
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
        
        //users gmo関連のカラム
        if (Schema::hasColumn('users', 'member_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('member_id');
            });
        }
        
        if (Schema::hasColumn('users', 'member_regist_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('member_regist_date');
            });
        }
        
        if (Schema::hasColumn('users', 'card_regist_count')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('card_regist_count');
            });
        }
        
        //user NoRegist gmo関連のカラム
        if (Schema::hasColumn('user_noregists', 'member_id')) {
            Schema::table('user_noregists', function (Blueprint $table) {
                $table->dropColumn('member_id');
            });
        }
        
    }
}
