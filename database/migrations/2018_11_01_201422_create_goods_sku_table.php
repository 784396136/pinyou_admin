<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_sku', function (Blueprint $table) {
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->string('sku_name')->comment('SKU名称');
            $table->unsignedInteger('stock')->comment('库存量');
            $table->decimal('price',10,2)->comment('价格');
            $table->index('goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_sku');
    }
}
