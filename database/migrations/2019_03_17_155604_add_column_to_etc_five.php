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
        
        //Item
        Schema::table('items', function (Blueprint $table) {
        	$table->boolean('is_secret')->after('open_status')->nullable()->default(0);
        });
        
        //Cate CateSec Tag
        Schema::table('categories', function (Blueprint $table) {
        	$table->string('upper_title')->after('meta_keyword')->nullable()->default(NULL);
        	$table->text('upper_text')->after('upper_title')->nullable()->default(NULL);
        });
        
        Schema::table('category_seconds', function (Blueprint $table) {
        	$table->string('upper_title')->after('meta_keyword')->nullable()->default(NULL);
        	$table->text('upper_text')->after('upper_title')->nullable()->default(NULL);
        });
        
        Schema::table('tags', function (Blueprint $table) {
        	$table->string('upper_title')->after('meta_keyword')->nullable()->default(NULL);
        	$table->text('upper_text')->after('upper_title')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	//Contact
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
        
        //Item
        if (Schema::hasColumn('items', 'is_secret')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn('is_secret');
            });
        }
        
        //Cate
        if (Schema::hasColumn('categories', 'upper_title')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('upper_title');
            });
        }
        
        if (Schema::hasColumn('categories', 'upper_text')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropColumn('upper_text');
            });
        }
        
        //CateSec
        if (Schema::hasColumn('category_seconds', 'upper_title')) {
            Schema::table('category_seconds', function (Blueprint $table) {
                $table->dropColumn('upper_title');
            });
        }
        
        if (Schema::hasColumn('category_seconds', 'upper_text')) {
            Schema::table('category_seconds', function (Blueprint $table) {
                $table->dropColumn('upper_text');
            });
        }
        
        //Tag
        if (Schema::hasColumn('tags', 'upper_title')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn('upper_title');
            });
        }
        
        if (Schema::hasColumn('tags', 'upper_text')) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropColumn('upper_text');
            });
        }
    }
}
