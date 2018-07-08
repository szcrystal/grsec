<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailMagazinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_magazines', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('title')->nullable()->default(NULL);
            $table->text('contents')->nullable()->default(NULL);
            
            $table->boolean('is_send')->nullable()->default(NULL);
            $table->timestamp('send_date')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('mail_magazines');
    }
}
