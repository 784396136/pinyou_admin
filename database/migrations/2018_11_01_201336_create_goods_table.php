<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_name')->comment('商品名称');
            $table->string('subtitle')->comment('副标题');
            $table->string('logo')->comment('商品logo');
            $table->string('thumbnails')->comment('商品logo缩略图');
            $table->longText('content')->comment('商品介绍');
            $table->unsignedInteger('brand_id')->comment('品牌ID');
            $table->unsignedInteger('cat1')->comment('一级分类');
            $table->unsignedInteger('cat2')->comment('二级分类');
            $table->unsignedInteger('cat3')->comment('三级分类');
            $table->unsignedInteger('seller_id')->comment('商家ID');
            $table->timestamps();
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
