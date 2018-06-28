<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(NULL);
            $table->string('link_name')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            
            $table->string('meta_title')->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->string('meta_keyword')->nullable()->default(NULL);
            
            $table->text('contents')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('categories')->insert([
                    'name' => '植木・庭木を選ぶ（シンボル）',
                    'slug' => 'ueki-niwaki',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('categories')->insert([
                    'name' => '苗木',
                    'slug' => 'naegi',
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        );
        
        DB::table('categories')->insert([
                    'name' => '生垣',
                    'slug' => 'ikegaki',
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
        Schema::dropIfExists('categories');
    }
}
