<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_image', function (Blueprint $table) {
            $table->unsignedInteger('goods_id')->comment('商品ID');
            $table->string('path')->comment('商品图片路径');
            $table->string('bg_path')->comment('大图');
            $table->string('md_path')->comment('中图');
            $table->string('sm_path')->comment('小图');
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
        Schema::dropIfExists('goods_image');
    }
}
