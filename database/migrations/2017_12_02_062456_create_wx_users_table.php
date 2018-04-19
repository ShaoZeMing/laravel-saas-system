<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wx_users', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('wx_unionid', 32)->default('')->comment('微信用户unionid')->index();
            $table->string('wx_openid', 32)->default('')->comment('微信用户openid')->index();
            $table->string('wx_nickname', 32)->default('')->comment('昵称');
            $table->string('wx_face')->default('')->comment('头像');
            $table->tinyInteger('wx_sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->string('wx_province')->default('')->comment('省');
            $table->string('wx_city')->default('')->comment('市');
            $table->string('wx_country')->default('')->comment('国家');
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
		Schema::drop('wx_users');
	}

}
