<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendMailFlagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_mail_flags', function (Blueprint $table) {
            $table->increments('id');
            
            //$table->integer('item_id');
            $table->integer('sale_id')->nullable()->default(NULL);
            $table->integer('templ_id')->nullable()->default(NULL);
            
            $table->string('templ_code')->nullable()->default(NULL);
            
            $table->boolean('is_mail')->nullable()->default(0);
            
            $table->integer('type')->nullable()->default(NULL);
            
            $table->text('information')->nullable()->default(NULL);
    
            //$table->string('url')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('send_mail_flags');
    }
}
