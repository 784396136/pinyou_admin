<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number')->comment('订单号');
            $table->string('name')->comment('收货人姓名');
            $table->bigInteger('moble')->comment("手机号码");
            $table->string('address')->comment('收货地址');
            $table->decimal('total_price',10,2)->comment('总价');
            $table->timestamps();
            $table->engine = "InnoDB";
            $table->comment = '订单表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
