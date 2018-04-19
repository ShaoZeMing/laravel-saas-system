<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Shaozeming\LumenPostgis\Schema\Blueprint;

class CreateUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('user_mobile', 12)->default('')->comment('电话');
            $table->string('user_name', 16)->default('')->comment('姓名');
            $table->string('user_nickname', 16)->default('')->comment('昵称');
            $table->string('user_face')->nullable()->comment('头像');
            $table->string('user_pwd', 64)->default('')->comment('密码');
            $table->string('user_pay_pwd', 64)->default('')->comment('提现密码');
            $table->date('user_birthday')->default('1900-01-01')->comment('生日');
            $table->tinyInteger('user_sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->tinyInteger('user_state')->default(0)->comment('状态：0正常，1锁定');
            $table->tinyInteger('user_is_notice')->default(1)->comment('是否推送通知：1推，不推');
            $table->decimal('user_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('user_lng',11,6)->default(0)->comment('经度');
            $table->geometry('user_geom',4326)->nullable()->comment('geom位置数据');
            $table->string('user_province')->default('')->comment('省');
            $table->integer('user_province_id')->default(0)->comment('省id');
            $table->string('user_city')->default('')->comment('市');
            $table->integer('user_city_id')->default(0)->comment('市id');
            $table->string('user_district')->default('')->comment('区、县');
            $table->integer('user_district_id')->default(0)->comment('区县id');
            $table->string('user_address')->default('')->comment('地址');
            $table->string('user_full_address')->default('')->comment('完整地址');
            $table->integer('user_order_cnt')->default(0)->comment('取消工单数');
            $table->bigInteger('wx_user_id')->default(0)->comment('微信信息表ID')->index();
            $table->timestamps();
            $table->primary('id');
            $table->index('user_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
