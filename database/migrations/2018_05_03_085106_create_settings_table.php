<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('admin_name')->nullable()->default(NULL);
            $table->string('admin_email')->nullable()->default(NULL);
            $table->text('mail_footer')->nullable()->default(NULL);
            $table->text('mail_user')->nullable()->default(NULL);
            
            $table->integer('tax_per')->nullable()->default(NULL);
            $table->text('bank_info')->nullable()->default(NULL);
            $table->integer('cot_per')->nullable()->default(NULL);
            
            $table->integer('snap_primary')->nullable()->default(NULL);
            $table->integer('snap_secondary')->nullable()->default(NULL);
            $table->integer('snap_category')->nullable()->default(NULL);
            
            $table->string('meta_title')->nullable()->default(NULL);
            $table->text('meta_description')->nullable()->default(NULL);
            $table->string('meta_keyword')->nullable()->default(NULL);
            
            
            $table->timestamps();
        });
        
        DB::table('settings')->insert([
                'admin_name' => 'GREEN ROCKET',
                'admin_email' => 'bonjour@frank.fam.cx',

                'tax_per' => 8,
                'bank_info' => "【振込先１】楽天銀行　ジャズ支店（普）7039167\n八進緑産株式会社　※カタカナ表記：ハッシンリョクサンカブシキガイシャ",
                
                'snap_primary'=> 10,
                'snap_secondary'=> 5,
                'snap_category'=> 3,
                
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
        Schema::dropIfExists('settings');
    }
}
