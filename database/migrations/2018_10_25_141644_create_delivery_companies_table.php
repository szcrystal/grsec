<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_companies', function (Blueprint $table) {
            $table->increments('id');            
            
            //$table->integer('item_id');
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('name_code')->nullable()->default(NULL);
            
            $table->integer('type')->nullable()->default(NULL);
    
            $table->string('url')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => '西濃運輸',
                //'open_status' => 1,
                'name_code' => 'seinou',
                'url'=> 'https://track.seino.co.jp/kamotsu/GempyoNoShokai.do',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => 'ヤマト運輸',
                'name_code'=> 'yamato',
                'url'=> 'https://toi.kuronekoyamato.co.jp/cgi-bin/tneko',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => '佐川急便',
                'name_code'=> 'sagawa',
                'url'=> 'http://k2k.sagawa-exp.co.jp/p/sagawa/web/okurijoinput.jsp',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => '日本郵便',
                'name_code'=> 'yuubin',
                'url'=> 'https://trackings.post.japanpost.jp/services/srv/search/input',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => '福山通運',
                'name_code'=> 'fukuyama',
                'url'=> 'https://corp.fukutsu.co.jp/situation/tracking_no',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => '第一貨物',
                'name_code'=> 'daiiti',
                'url'=> 'http://www.daiichi-kamotsu.co.jp/chase/contact_num/',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('delivery_companies')->insert(
            [ 
                'name' => 'トナミ運輸',
                'name_code'=> 'tonami',
                'url'=> 'https://trc1.tonami.co.jp/trc/search3/excSearch3',
                
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
        Schema::dropIfExists('delivery_companies');
    }
}
