<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->boolean('del_status');
            
            $table->integer('cate_id');
            $table->string('title');
            $table->string('movie_site');
            $table->string('movie_url')->unique();
            
            $table->string('thumbnail')->nullable()->default(NULL);
            $table->string('thumbnail_org')->nullable()->default(NULL);
            $table->text('thumbnail_comment')->nullable()->default(NULL);
            
            $table->boolean('open_status');
            $table->boolean('open_history');
            $table->timestamp('open_date')->nullable()->default(NULL);
            $table->boolean('not_newdate');
            //$table->integer('view_count');
            
            $table->timestamps();
            
            $table->index('owner_id');
            $table->index(['open_status','del_status']);
        });
        
        $n = 0;
        while($n < 1) {
            DB::table('items')->insert([
                    'owner_id' => 0,
                    'del_status' => 0,
                    
                    'cate_id' => 1,
                    'title' => '【メッシ 神業ドリブルが炸裂！】バルセロナ vs エスパニョール 4-1 全ゴールハイライト',
                    'movie_site' => 'youtube',
                    'movie_url' => 'https://www.youtube.com/watch?v=8wWZs3WQyF4',

                    'thumbnail' => '',
                    'thumbnail_org' => '',
                    'thumbnail_comment' => '',
                       
                    'open_status' => 0,
                    'open_history' => 0,
                    'open_date' => '2017-01-10 11:11:11',
                    'not_newdate' => 0,
                    //'view_count' => $n+3,
                    
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            $n++;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
