<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('open_status');
            
            $table->string('number')->nullable()->default(NULL);
            $table->string('title');
            $table->string('catchcopy')->nullable()->default(NULL);
            $table->integer('cate_id')->nullable()->default(NULL);
            $table->integer('subcate_id')->nullable()->default(NULL);
            
            $table->string('main_img')->nullable()->default(NULL);
            /*
            $table->string('spare_img_0')->nullable()->default(NULL);
            $table->string('spare_img_1')->nullable()->default(NULL);
            $table->string('spare_img_2')->nullable()->default(NULL);
            $table->string('spare_img_3')->nullable()->default(NULL);
            $table->string('spare_img_4')->nullable()->default(NULL);
            $table->string('spare_img_5')->nullable()->default(NULL);
            $table->string('spare_img_6')->nullable()->default(NULL);
            $table->string('spare_img_7')->nullable()->default(NULL);
            $table->string('spare_img_8')->nullable()->default(NULL);
            $table->string('spare_img_9')->nullable()->default(NULL);
            */
            
            $table->boolean('farm_direct')->nullable()->default(NULL);
            
            $table->integer('price')->nullable()->default(NULL);
            $table->integer('cost_price')->nullable()->default(NULL);
            $table->string('consignor_id')->nullable()->default(NULL);
            $table->integer('dg_id')->nullable()->default(NULL);
            $table->boolean('deli_fee')->nullable()->default(NULL);
            $table->integer('cod')->nullable()->default(NULL);
            
            $table->integer('stock')->nullable()->default(NULL);
            $table->boolean('stock_show')->nullable()->default(NULL);
            
            $table->integer('point_back')->nullable()->default(NULL);
            
            $table->text('exp_first')->nullable()->default(NULL);
            $table->text('explain')->nullable()->default(NULL);
            $table->text('about_ship')->nullable()->default(NULL);
            $table->text('detail')->nullable()->default(NULL);
            
            
            $table->text('what_is')->nullable()->default(NULL);
            $table->text('warning')->nullable()->default(NULL);
            
            $table->timestamp('open_date')->nullable()->default(NULL);
            
            $table->integer('view_count')->nullable()->default(0);
            $table->integer('sale_count')->nullable()->default(0);
            
            $table->timestamps();
            
            //$table->index('owner_id');
            //$table->index(['open_status','del_status']);
        });
        
        $n = 0;
        while($n < 1) {
            DB::table('items')->insert([
                    'open_status' => 1,
                    
                    'number' => 'mpm25-2',
                    'title' => 'シマトネリコ 株立 1.7m程度（根鉢含まず）',
                    'catchcopy' => '薄紫色品種の「マスコギー」',
                    'cate_id' => 1,
                    'subcate_id'=>1,
                    
                    'main_img' => '',
//                    'spare_img_0' => '',
//                    'spare_img_1' => '',
//                    'spare_img_2' => '',
//                    'spare_img_3' => '',
//                    'spare_img_4' => '',
//                    'spare_img_5' => '',
//                    'spare_img_6' => '',
//                    'spare_img_7' => '',
//                    'spare_img_8' => '',
//                    'spare_img_9' => '',
                    
                    'price' => 14000,
                    'cost_price' => 8500,
                    
                    'consignor_id' => 1,
            		'cod' => 1,
              		'dg_id' =>1,
                	'deli_fee'=>0,          
            		'stock' => 20,
                    'stock_show' => 1,
                    'point_back' => 2,
                    
                    'about_ship' => 'オールマイティな活躍をしてくれるシマトネリコだけに、当店のシマトネリコの特徴は、端正で素直な樹形のものだけを厳選している点です。',
                    'detail' => 'オールマイティな活躍をしてくれるシマトネリコだけに、当店のシマトネリコの特徴は、端正で素直な樹形のものだけを厳選している点です。',
                    'explain' => 'オールマイティな活躍をしてくれるシマトネリコだけに、当店のシマトネリコの特徴は、端正で素直な樹形のものだけを厳選している点です。',
                    
                    'what_is' => 'シマトネリコは最近とても人気が高くなっている常緑樹です。',
                    //'detail' => '',
                    'warning' => '',
                    
                    'open_date' => '2018-05-10 11:11:11',
                    'view_count' => 3,
                    
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            $n++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
