<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleRelationCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_relation_cancels', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('order_number')->nullable()->default(NULL);            
            $table->integer('salerel_id')->nullable()->default(NULL);
            $table->integer('pay_method')->nullable()->default(NULL);
            
            $table->integer('deli_fee')->nullable()->default(NULL);
            $table->integer('cod_fee')->nullable()->default(NULL);
            $table->integer('use_point')->nullable()->default(NULL);
            $table->integer('add_point')->nullable()->default(NULL);
            $table->integer('all_price')->nullable()->default(NULL);
            $table->integer('total_price')->nullable()->default(NULL);
            
            $table->boolean('pay_done')->nullable()->default(NULL);
            $table->timestamp('pay_date')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('sale_relation_cancels');
    }
}
