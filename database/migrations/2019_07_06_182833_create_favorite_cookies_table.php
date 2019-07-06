<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteCookiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_cookies', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('key')->nullable()->default(NULL);
            
            $table->integer('item_id')->nullable()->default(NULL);
            $table->string('type')->nullable()->default(NULL);
            
            $table->mediumText('value')->nullable()->default(NULL);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_cookies');
    }
}
