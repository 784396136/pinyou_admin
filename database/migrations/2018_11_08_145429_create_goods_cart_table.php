<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->string('sku_name')->comment('商品名称');
            $table->string('attr')->comment('属性');
            $table->string('sm_path')->comment('图片路径');
            $table->unsignedInteger('stock')->comment('收藏量');
            $table->decimal('price',10,2)->comment('单价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_cart');
    }
}
