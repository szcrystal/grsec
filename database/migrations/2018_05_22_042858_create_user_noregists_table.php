<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNoregistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_noregists', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name');
            $table->string('email')->nullable()->default(NULL);
            
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
            
            
            $table->string('tel_num')->nullable()->default(NULL);
            
            $table->boolean('magazine')->nullable()->default(NULL);
            $table->boolean('user_register')->nullable()->default(NULL);
            $table->integer('point')->nullable()->default(NULL);
            
            $table->boolean('destination')->nullable()->default(NULL);
            
            $table->integer('active')->nullable()->default(1);
            
            
            //$table->string('password');
            //$table->string('confirm_token')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::statement('ALTER TABLE user_noregists CHANGE post_num post_num INT(7) UNSIGNED ZEROFILL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_noregists');
    }
}
