<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Shaozeming\LumenPostgis\Schema\Blueprint;

class CreateWorkersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('workers', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('worker_mobile', 12)->default('')->comment('电话');
            $table->string('worker_name', 16)->default('')->comment('姓名');
            $table->string('worker_nickname', 16)->default('')->comment('昵称');
            $table->string('worker_face')->nullable()->comment('头像');
            $table->string('worker_pwd', 64)->default('')->comment('密码');
            $table->string('worker_pay_pwd', 64)->default('')->comment('提现密码');
            $table->date('worker_birthday')->default('1900-01-01')->comment('生日');
            $table->tinyInteger('worker_sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->tinyInteger('worker_state')->default(0)->comment('状态：0正常，1锁定');
            $table->tinyInteger('worker_is_notice')->default(1)->comment('是否推送通知：1推，不推');
            $table->decimal('worker_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('worker_lng',11,6)->default(0)->comment('经度');
            $table->geometry('worker_geom',4326)->nullable()->comment('geom位置数据');
            $table->string('worker_province')->default('')->comment('省');
            $table->string('worker_city')->default('')->comment('市');
            $table->string('worker_district')->default('')->comment('区、县');
            $table->string('worker_address')->default('')->comment('地址');
            $table->integer('worker_province_id')->default(0)->comment('省id');
            $table->integer('worker_city_id')->default(0)->comment('市id');
            $table->integer('worker_district_id')->default(0)->comment('区县id');
            $table->string('worker_full_address')->default('')->comment('完整地址');
            $table->integer('worker_cancel_cnt')->default(0)->comment('取消工单数');
            $table->integer('worker_success_cnt')->default(0)->comment('完成工单数');
            $table->integer('worker_brokerage_percent')->default(0)->comment('抽佣百分比');
            $table->bigInteger('wx_user_id')->default(0)->comment('微信信息表ID')->index();

            $table->timestamps();
            $table->primary('id');
            $table->index('worker_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('workers');
	}

}
