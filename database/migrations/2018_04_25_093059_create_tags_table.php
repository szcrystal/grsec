<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            
            $table->string('meta_title')->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->string('meta_keyword')->nullable()->default(NULL);
            
            $table->text('contents')->nullable()->default(NULL);
            
            $table->integer('view_count')->nullable()->default(0);
            
            $table->timestamps();
            
            //$table->index('group_id');
        });
        
        
            DB::table('tags')->insert([
                    'name' => '落葉樹',
                    'slug' => 'rakuyoujyu',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
                    'name' => '緑',
                    'slug' => 'green',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]
            );
            
            DB::table('tags')->insert([
                    'name' => '赤',
                    'slug' => 'red',
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
        Schema::dropIfExists('tags');
    }
}
