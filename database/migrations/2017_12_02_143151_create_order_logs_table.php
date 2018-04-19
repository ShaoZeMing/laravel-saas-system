<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_logs', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->tinyInteger('type')->default(0)->comment('日志类型');
            $table->bigInteger('order_id')->default(0)->comment('工单ID')->index();
            $table->json('data')->default('{}')->comment('操作log数据集');
            $table->timestamps();
            $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_logs');
	}

}
