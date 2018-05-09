<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('tax_per')->nullable()->default(NULL);
            $table->text('bank_info')->nullable()->default(NULL);
            
            $table->string('admin_name')->nullable()->default(NULL);
            $table->string('admin_email')->nullable()->default(NULL);
            
            $table->text('mail_footer')->nullable()->default(NULL);
            
            $table->text('mail_user')->nullable()->default(NULL);
            
            
            
            
            
            
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
        Schema::dropIfExists('settings');
    }
}
