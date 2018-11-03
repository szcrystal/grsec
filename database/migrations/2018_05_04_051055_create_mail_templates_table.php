<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('type_code')->nullable()->default(NULL);
            $table->string('type_name')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->text('header')->nullable()->default(NULL);
            $table->text('footer')->nullable()->default(NULL);
            
            
            $table->timestamps();
        });
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'contact',
                'type_name' => 'お問い合わせ',
                'title' => 'お問い合わせありがとうございます',
                'header' => 'aaa',
                'footer' => '111',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'register',
                'type_name' => '会員登録',
                'title' => 'ご登録ありがとうございます',
                'header' => 'bbb',
                'footer' => '222',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'itemEnd',
                'type_name' => 'ご注文完了',
                'title' => 'ご注文ありがとうございます',
                'header' => 'ccc',
                'footer' => '333',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'ensure_7',
                'type_name' => '枯れ保証 ７日',
                'title' => '枯れ保証期間について',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'ensure_33',
                'type_name' => '枯れ保証 33日',
                'title' => '枯れ保証期間について',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'ensure_96',
                'type_name' => '枯れ保証 96日',
                'title' => '枯れ保証期間について',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'ensure_155',
                'type_name' => '枯れ保証 155日',
                'title' => '枯れ保証期間について',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'no_ensure_33',
                'type_name' => '枯れ保証なし 33日',
                'title' => '枯れ保証なしについて',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'payDone',
                'type_name' => 'ご入金完了',
                'title' => 'ご入金を確認しました',
                'header' => 'eee',
                'footer' => '55555',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'thanks',
                'type_name' => 'サンクス',
                'title' => 'サンクス',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'stockNow',
                'type_name' => '在庫確認中',
                'title' => '',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'howToUe',
                'type_name' => '植え付け方法のご案内',
                'title' => '',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'deliDoneNo',
                'type_name' => '出荷完了(伝票番号未確認)',
                'title' => '',
                'header' => 'ababab',
                'footer' => '121212',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'deliDone',
                'type_name' => '出荷完了',
                'title' => '商品を出荷しました',
                'header' => 'ddd',
                'footer' => '444',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );

		DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'cancel',
                'type_name' => 'キャンセル',
                'title' => 'キャンセル致しました',
                'header' => 'ddd',
                'footer' => '444',
                
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
        Schema::dropIfExists('mail_templates');
    }
}
