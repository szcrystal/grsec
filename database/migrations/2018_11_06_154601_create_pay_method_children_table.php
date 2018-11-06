<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayMethodChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_method_children', function (Blueprint $table) {
            $table->increments('id');
            
            //$table->integer('item_id');
            $table->integer('parent_id')->nullable()->default(NULL);
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('sec_name')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('pay_method_children')->insert(
            [ 
            	'parent_id'=> 3,
                'name' => 'ジャパンネット銀行',
                'sec_name' => 'ジャパネ',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('pay_method_children')->insert(
            [ 
            	'parent_id'=> 3,
                'name' => '楽天銀行',
                'sec_name' => '楽天',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('pay_method_children')->insert(
            [ 
            	'parent_id'=> 3,
                'name' => '住信SBIネット銀行',
                'sec_name' => '住信',
                
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
        Schema::dropIfExists('pay_method_children');
    }
}
