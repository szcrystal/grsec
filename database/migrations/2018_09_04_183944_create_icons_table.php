<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('title')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->string('img_path')->nullable()->default(NULL);
            
            
            $table->timestamps();
        });
        
        $arr = [
        	'代金引換不可'=>'icon_daibiki',
            '送料無料'=>'icon_delifee',
            '現品発送'=>'icon_genpin',
            '6ヶ月枯れ保証'=>'icon_kare_ensure',
        ];
        
        foreach($arr as $key => $val) {
            DB::table('icons')->insert([
                    'title' => $key,
                    'name' => $val,
                    
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icons');
    }
}
