<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignors', function (Blueprint $table) {
            $table->increments('id');
                        
            $table->string('name')->nullable()->default(NULL);
            $table->integer('tel_num')->nullable()->default(NULL);
            $table->string('address')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('consignors')->insert(
            [ 
                'name' => 'ABC社',
                'tel_num' => 0311112222,
                'address' => '東京都東京',
                
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
        Schema::dropIfExists('consignors');
    }
}
