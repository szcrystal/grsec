<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefectures', function (Blueprint $table) {
            $table->increments('id');
            
            //$table->integer('code')->nullable()->default(NULL);
            $table->string('rural')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('roma_name')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('prefectures')->insert(
        	[
         		//'code' => 01,   
        		'rural' => '北海道',
                'name' => '北海道',
                'roma_name' => 'hokkaido',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );

        DB::table('prefectures')->insert(
            [
            	//'code' => 02, 
                'rural' => '東北',
                'name' => '青森県',
                'roma_name' => 'aomori',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('prefectures')->insert(
            [
            	//'code' => 03, 
                'rural' => '東北',
                'name' => '岩手県',
                'roma_name' => 'iwate',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
         
        DB::table('prefectures')->insert(   
            [
                'rural' => '東北',
                'name' => '宮城県',
                'roma_name' => 'miyagi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '東北',
                'name' => '秋田県',
                'roma_name' => 'akita',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '東北',
                'name' => '山形県',
                'roma_name' => 'yamagata',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '東北',
                'name' => '福島県',
                'roma_name' => 'fukushima',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '茨城県',
                'roma_name' => 'ibaraki',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '栃木県',
                'roma_name' => 'tochigi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ] 
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '群馬県',
                'roma_name' => 'gumma',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ] 
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '埼玉県',
                'roma_name' => 'saitama',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '千葉県',
                'roma_name' => 'chiba',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '東京都',
                'roma_name' => 'tokyo',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '関東',
                'name' => '神奈川県',
                'roma_name' => 'kanagawa',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '新潟県',
                'roma_name' => 'niigata',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '富山県',
                'roma_name' => 'toyama',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '石川県',
                'roma_name' => 'ishikawa',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '福井県',
                'roma_name' => 'fukui',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '山梨県',
                'roma_name' => 'yamanashi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '長野県',
                'roma_name' => 'nagano',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '岐阜県',
                'roma_name' => 'gifu',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '静岡県',
                'roma_name' => 'shizuoka',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中部',
                'name' => '愛知県',
                'roma_name' => 'aichi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '三重県',
                'roma_name' => 'mie',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '滋賀県',
                'roma_name' => 'shiga',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '京都府',
                'roma_name' => 'kyoto',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '大阪府',
                'roma_name' => 'osaka',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '兵庫県',
                'roma_name' => 'hyogo',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '奈良県',
                'roma_name' => 'nara',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '近畿',
                'name' => '和歌山県',
                'roma_name' => 'wakayama',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中国',
                'name' => '鳥取県',
                'roma_name' => 'tottori',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中国',
                'name' => '島根県',
                'roma_name' => 'shimane',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中国',
                'name' => '岡山県',
                'roma_name' => 'okayama',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中国',
                'name' => '広島県',
                'roma_name' => 'hiroshima',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '中国',
                'name' => '山口県',
                'roma_name' => 'yamaguchi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '四国',
                'name' => '徳島県',
                'roma_name' => 'tokushima',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '四国',
                'name' => '香川県',
                'roma_name' => 'kagawa',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '四国',
                'name' => '愛媛県',
                'roma_name' => 'ehime',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '四国',
                'name' => '高知県',
                'roma_name' => 'kochi',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '福岡県',
                'roma_name' => 'fukuoka',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '佐賀県',
                'roma_name' => 'saga',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '長崎県',
                'roma_name' => 'nagasaki',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '熊本県',
                'roma_name' => 'kumamoto',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '大分県',
                'roma_name' => 'oita',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '宮崎県',
                'roma_name' => 'miyazaki',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '九州',
                'name' => '鹿児島県',
                'roma_name' => 'kagoshima',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]  
        );
        
        DB::table('prefectures')->insert(    
            [
                'rural' => '沖縄',
                'name' => '沖縄県',
                'roma_name' => 'okinawa',
                
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
        Schema::dropIfExists('prefectures');
    }
}
