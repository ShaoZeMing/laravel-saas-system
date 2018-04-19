<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeReceiversTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
     * 通知状态表
	 */
	public function up()
	{
		Schema::create('notice_receivers', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->tinyInteger('state')->default(0)->comment('0未读，1已读');
            $table->bigInteger('notice_id')->default(0)->comment('师傅ID');
            $table->string('wx_msg_id',24)->default('')->comment('微信消息ID');
            $table->bigInteger('noticeable_id')->default(0)->comment('关联对象ID');
            $table->string('noticeable_type',64)->default('')->comment('关联对象');
            $table->timestamps();
            $table->primary('id');
            $table->index('notice_id');
            $table->index(['noticeable_id','noticeable_type']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notice_receivers');
	}

}
