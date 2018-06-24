<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategorySecondsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_seconds', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('parent_id');
            $table->string('name')->nullable()->default(NULL);
            $table->string('slug')->unique()->nullable()->default(NULL);
            
            $table->string('meta_title')->nullable()->default(NULL);
            $table->string('meta_description')->nullable()->default(NULL);
            $table->string('meta_keyword')->nullable()->default(NULL);
            
            $table->text('contents')->nullable()->default(NULL);
            
            $table->timestamps();
        });
        
        DB::table('category_seconds')->insert([
                'parent_id' => 1,
                'name' => '庭',
                'slug' => 'garden',
                
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
        Schema::dropIfExists('category_seconds');
    }
}
