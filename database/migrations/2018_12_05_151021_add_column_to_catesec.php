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
    	//categorySecondにmain_imgのカラム追加
    	Schema::table('category_seconds', function (Blueprint $table) {
        	$table->string('main_img')->after('slug')->nullable()->default(NULL);
        });
        
        //Settingにsnap_newsのカラム追加
    	Schema::table('settings', function (Blueprint $table) {
        	$table->integer('snap_news')->after('cot_per')->nullable()->default(1);
            
            $table->integer('snap_block_a')->after('snap_secondary')->nullable()->default(1);
            $table->integer('snap_block_b')->after('snap_block_a')->nullable()->default(4);
            $table->integer('snap_block_c')->after('snap_block_b')->nullable()->default(6);
            
        });
        
        //Settingにsnap_newsのカラム追加
    	Schema::table('tag_relations', function (Blueprint $table) {
        	$table->integer('sort_num')->after('tag_id')->nullable()->default(null);
        });
        
        
        
        //メールテンプレに下記データ追加
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'simatone_ettou',
                'type_name' => 'シマトネリコ　越冬　厳しい',
                'title' => 'シマトネリコ　越冬　厳しい',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'sekkai_iou',
                'type_name' => '石灰硫黄合剤の説明用',
                'title' => '石灰硫黄合剤の説明用',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );

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
        
        DB::table('mail_templates')->whereIn('type_code', ['simatone_ettou', 'sekkai_iou'])->delete();
        
        
        if (Schema::hasColumn('settings', 'snap_news')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('snap_news');
            });
        }
        
        if (Schema::hasColumn('settings', 'snap_block_a')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('snap_block_a');
            });
        }
        
        if (Schema::hasColumn('settings', 'snap_block_b')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('snap_block_b');
            });
        }
        
        if (Schema::hasColumn('settings', 'snap_block_c')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('snap_block_c');
            });
        }
        
        if (Schema::hasColumn('tag_relations', 'sort_num')) {
            Schema::table('tag_relations', function (Blueprint $table) {
                $table->dropColumn('sort_num');
            });
        }
        
        
    }
}
