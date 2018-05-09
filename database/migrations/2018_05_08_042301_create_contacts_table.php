<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('email')->nullable()->default(NULL);
            $table->string('ask_category')->nullable()->default(NULL);            
            
            $table->text('comment')->nullable()->default(NULL);
            
            $table->boolean('status')->nullable()->default(NULL);
            $table->boolean('accept')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('contacts');
    }
}
