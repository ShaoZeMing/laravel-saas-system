<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('mobile', 12)->default('')->comment('电话/账号');
            $table->string('name', 16)->default('')->comment('姓名');
            $table->string('email', 64)->default('')->comment('邮箱');
            $table->string('face')->nullable()->comment('头像');
            $table->string('pwd', 64)->default('')->comment('密码');
            $table->string('pay_pwd', 64)->default('')->comment('提现密码');
            $table->date('birthday')->default('1900-01-01')->comment('生日');
            $table->tinyInteger('sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->tinyInteger('state')->default(0)->comment('状态：0正常，1锁定');
            $table->char('login_ip')->default('0.0.0.0')->comment('上次登陆ip');
            $table->timestamps();
            $table->primary('id');
            $table->index('mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('admins');
	}

}
