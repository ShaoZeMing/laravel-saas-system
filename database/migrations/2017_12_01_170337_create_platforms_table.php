<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('platforms', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('platform_mobile', 12)->default('')->comment('电话');
            $table->string('platform_name', 16)->default('')->comment('姓名');
            $table->string('platform_nickname', 16)->default('')->comment('昵称');
            $table->string('platform_face')->default('')->comment('头像');
            $table->string('platform_pwd', 64)->default('')->comment('密码');
            $table->string('platform_pay_pwd', 64)->default('')->comment('提现密码');
            $table->timestamps();
            $table->primary('id');
            $table->index('platform_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('platforms');
	}

}
