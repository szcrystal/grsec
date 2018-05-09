<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryGroupRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_group_relations', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('dg_id')->nullable()->default(NULL);
            $table->string('pref_id')->nullable()->default(NULL);
            $table->integer('fee')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('delivery_group_relations')->insert(
            [ 
                'dg_id' => 1,
                'pref_id' => 1,
                'fee' => 1500,
                
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
        Schema::dropIfExists('delivery_group_relations');
    }
}
