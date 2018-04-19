<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->tinyInteger('type')->default(0)->comment('日志类型');
            $table->tinyInteger('stars')->default(0)->comment('评价星级');
            $table->bigInteger('worker_id')->default(0)->comment('师傅ID')->index();
            $table->bigInteger('order_id')->default(0)->comment('工单ID')->index();
            $table->bigInteger('commentable_id')->default(0)->comment('关联对象ID');
            $table->string('commentable_type',64)->default('')->comment('关联对象');
            $table->json('content')->default('{}')->comment('评价标签json');
            $table->string('other_content',200)->default('')->comment('其他评价');
            $table->timestamps();
            $table->primary('id');
            $table->index(['worker_id','order_id']);
            $table->index(['commentable_id','commentable_type']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comments');
	}

}
