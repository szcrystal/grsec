<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStockChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_stock_changes', function (Blueprint $table) {

            $table->increments('id');
                        
            $table->integer('item_id')->nullable()->default(NULL);
            $table->boolean('is_auto')->nullable()->default(0);
            
//            $table->string('top_title')->nullable()->default(NULL);
//            $table->text('top_text')->nullable()->default(NULL);
            
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
        Schema::dropIfExists('item_stock_changes');
    }
}
