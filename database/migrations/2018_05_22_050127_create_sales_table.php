<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('salerel_id')->nullable()->default(NULL);
            $table->string('order_number')->nullable()->default(NULL);
            
            $table->integer('item_id')->nullable()->default(NULL);
            $table->integer('item_count')->nullable()->default(NULL);
            
            /*
            $table->boolean('regist')->nullable()->default(NULL);
            $table->integer('user_id')->nullable()->default(NULL);
            $table->boolean('is_user')->nullable()->default(NULL);
            $table->integer('receiver_id')->nullable()->default(NULL);
            */
            
            $table->string('plan_date')->nullable()->default(NULL);
            $table->string('plan_time')->nullable()->default(NULL);
            
            $table->integer('pay_method')->nullable()->default(NULL);
            $table->integer('deli_fee')->nullable()->default(NULL);
            $table->integer('cod_fee')->nullable()->default(NULL);
            $table->integer('use_point')->nullable()->default(NULL);
            
            $table->integer('single_price')->nullable()->default(NULL);
            $table->integer('total_price')->nullable()->default(NULL);
            $table->integer('cost_price')->nullable()->default(NULL);
            
            $table->integer('charge_loss')->nullable()->default(NULL);
            $table->integer('arari')->nullable()->default(NULL);
            
            $table->string('deli_company_id')->nullable()->default(NULL);
            $table->string('deli_slip_num')->nullable()->default(NULL);
            
            $table->string('deli_start_date')->nullable()->default(NULL);
            $table->string('deli_schedule_date')->nullable()->default(NULL);
            
            $table->timestamp('deli_sended_date')->nullable()->default(NULL);
            
            $table->boolean('deli_done')->nullable()->default(0);
            
            $table->boolean('is_cancel')->nullable()->default(0);
            
//            $table->boolean('thanks_done')->nullable()->default(0);
//            $table->boolean('stocknow_done')->nullable()->default(0);
            
            //$table->boolean('pay_done')->nullable()->default(NULL);

//            $table->text('information')->nullable()->default(NULL);
//            $table->text('memo')->nullable()->default(NULL);
//            $table->text('craim')->nullable()->default(NULL);
            
            /*
            $table->boolean('destination')->nullable()->default(NULL);
            
            $table->integer('pay_trans_code')->nullable()->default(NULL);
            $table->integer('pay_user_id')->nullable()->default(NULL);
            
            $table->string('pay_payment_code')->nullable()->default(NULL); //ネットバンク、GMO後払いのみ  
            $table->integer('pay_result')->nullable()->default(NULL); //クレカのみ
            $table->integer('pay_state')->nullable()->default(NULL);
            */

            
            //$table->string('prefecture')->nullable()->default(NULL);
            
            
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
        Schema::dropIfExists('sales');
    }
}
