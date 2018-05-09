<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hurigana')->nullable()->default(NULL);
            $table->string('gender')->nullable()->default(NULL);
            
            $table->integer('birth_year')->nullable()->default(NULL);
            $table->integer('birth_month')->nullable()->default(NULL);
            $table->integer('birth_day')->nullable()->default(NULL);
            
            $table->integer('post_num')->nullable()->default(NULL);
            $table->string('prefecture')->nullable()->default(NULL);
            $table->string('address_1')->nullable()->default(NULL);
            $table->string('address_2')->nullable()->default(NULL);
            $table->string('address_3')->nullable()->default(NULL);
            
            $table->string('email')->unique();
            $table->integer('tel_num')->nullable()->default(NULL);
            
            $table->boolean('magazine')->nullable()->default(NULL);
            $table->boolean('user_register')->nullable()->default(NULL);
            $table->integer('point')->nullable()->default(NULL);
            
            $table->boolean('destination')->nullable()->default(NULL);
            
            $table->boolean('active');
            
            
            $table->string('password');
            $table->string('confirm_token')->nullable()->default(NULL);
            
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
                'name' => 'gr-user',
                'email' => 'gr@gr.com',
                'password' => bcrypt('grgrgr'),
                
                'hurigana' => 'ジーアール',
                'gender' => '男性',

				'birth_year' => 2000,
                'birth_month' => 1,
                'birth_day' => 10,
                
                'post_num' => 1001701,
                'prefecture' => '東京都',
                'address_1' => '青ヶ島村',
                'address_2' => '1番',
                'address_3' => 'ABCビル',
                
                'tel_num' => 0311112222,
                
                'magazine' => 1,
                'user_register' =>1,
                'point' => 150,
                
                'destination' => 1, //配送先の設定
                
                'active' => 1,
                
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('users')->insert([
                'name' => 'opal',
                'email' => 'opal@frank.fam.cx',
                'password' => bcrypt('aaaaa111'),
                'active' => 1,
//                'hurigana'
//                'gender'
//
//                'birth_year'
//                'birth_month'
//                'birth_day'
//                
//                'post_num'
//                'prefecture'
//                'city'
//                'lot_num'
//                'building'
//                
//                'tel_num'
//                
//                'magazine'
//                'user_register'
//                
//                'destination'

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
        Schema::dropIfExists('users');
    }
}
