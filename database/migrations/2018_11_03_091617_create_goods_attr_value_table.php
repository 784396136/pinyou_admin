<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttrValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_attr_value', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->unsignedInteger('name_id')->comment('属性ID');
            $table->string('attr_value')->comment('属性值');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_attr_value');
    }
}
