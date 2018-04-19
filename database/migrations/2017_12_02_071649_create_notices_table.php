<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notices', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->tinyInteger('state')->default(0)->comment('通知状态');
            $table->tinyInteger('type')->default(0)->comment('通知类型');
            $table->bigInteger('order_id')->default(0)->comment('工单ID');
            $table->string('title',120)->default('')->comment('标题');
            $table->json('content')->default('{}')->comment('发送内容json格式');
            $table->timestamps();
            $table->primary('id');
            $table->index('order_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notices');
	}

}
