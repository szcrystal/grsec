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
                'type_code' => 'inquire',
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
                'type_code' => 'user_register',
                'type_name' => '会員登録完了',
                'title' => 'ご登録ありがとうございます',
                'header' => 'bbb',
                'footer' => '222',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'item_end',
                'type_name' => '注文完了',
                'title' => 'ご注文ありがとうございます',
                'header' => 'ccc',
                'footer' => '333',
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('mail_templates')->insert(
            [ 
                'type_code' => 'item_delivery',
                'type_name' => '発送完了',
                'title' => '商品を発送しました',
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
