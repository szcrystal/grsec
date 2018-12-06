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
    }
}
