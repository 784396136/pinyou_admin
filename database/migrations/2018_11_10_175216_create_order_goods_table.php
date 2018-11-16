<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('sku_id')->comment('SKU ID');
            $table->unsignedInteger('stock')->comment('商品数量');
            $table->enum('pay_status',[0,1,2])->default(0)->comment('支付状态 0未支付 1已支付 2已退款');
            $table->enum('post_status',[0,1,2,3])->default(0)->comment('发货状态 0未发货 1已发货 2已签收 3已退货');
            $table->timestamps();
            $table->engine = "InnoDB";
            $table->comment = '订单商品表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods');
    }
}
