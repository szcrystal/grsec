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
            
            $table->string('main_img')->nullable()->default(NULL);
            $table->integer('cate_id');
            $table->string('title');
            $table->integer('price')->nullable()->default(NULL);
            $table->integer('delivery_fee')->nullable()->default(NULL);
            
            
            $table->text('what_is')->nullable()->default(NULL);
            $table->text('detail')->nullable()->default(NULL);
            $table->text('warning')->nullable()->default(NULL);
            
            $table->timestamp('open_date')->nullable()->default(NULL);
            //$table->integer('view_count');
            
            $table->timestamps();
            
            //$table->index('owner_id');
            //$table->index(['open_status','del_status']);
        });
        
        $n = 0;
        while($n < 1) {
            DB::table('items')->insert([
                    'open_status' => 1,
                    
                    'main_img' => '',
                    'cate_id' => 1,
                    'title' => 'シマトネリコ 株立 1.7m程度（根鉢含まず）',
                    'price' => 14000,
                    'delivery_fee' => 2500,
                    'what_is' => 'シマトネリコは最近とても人気が高くなっている常緑樹です。',

                   
                    'detail' => 'オールマイティな活躍をしてくれるシマトネリコだけに、当店のシマトネリコの特徴は、端正で素直な樹形のものだけを厳選している点です。',
                    'warning' => '木の状態は季節により変化いたします。',
                       
                    'open_date' => '2018-05-10 11:11:11',
                    //'view_count' => $n+3,
                    
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
