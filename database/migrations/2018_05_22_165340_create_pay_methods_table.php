<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_methods', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name')->nullable()->default(NULL);
            $table->string('sec_name')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('pay_methods')->insert([
        	'name' => 'クレジットカード',
            'sec_name' => 'クレカ',
         	'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),   
        ]);
        
        DB::table('pay_methods')->insert([
            'name' => 'コンビニ決済',
            'sec_name' => 'コンビニ',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        
        DB::table('pay_methods')->insert([
            'name' => 'ネットバンク決済',
            'sec_name' => 'ネトバ',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        
        DB::table('pay_methods')->insert([
            'name' => 'GMO後払い',
            'sec_name' => 'GMO',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        
        DB::table('pay_methods')->insert([
            'name' => '代金引換',
            'sec_name' => '代引',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
        
        DB::table('pay_methods')->insert([
            'name' => '銀行振込',
            'sec_name' => '銀振',
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_methods');
    }
}
