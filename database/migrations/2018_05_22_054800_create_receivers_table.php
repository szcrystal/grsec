<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('user_id')->nullable()->default(NULL);
            $table->boolean('regist')->nullable()->default(NULL);
            
            $table->integer('order_number')->nullable()->default(NULL);
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('hurigana')->nullable()->default(NULL);
            $table->string('tel_num')->nullable()->default(NULL);
            
            $table->integer('post_num')->nullable()->default(NULL);
            $table->string('prefecture')->nullable()->default(NULL);
            $table->string('address_1')->nullable()->default(NULL);
            $table->string('address_2')->nullable()->default(NULL);
            $table->string('address_3')->nullable()->default(NULL);
            
            
            
            $table->timestamps();
        });
        
        DB::statement('ALTER TABLE receivers CHANGE post_num post_num INT(7) UNSIGNED ZEROFILL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receivers');
    }
}
