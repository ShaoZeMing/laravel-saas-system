<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Shaozeming\LumenPostgis\Schema\Blueprint;

class CreateSitesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sites', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('site_mobile', 12)->default('')->comment('电话');
            $table->string('site_name', 16)->default('')->comment('姓名');
            $table->string('site_nickname', 32)->default('')->comment('公司名称');
            $table->string('site_face')->nullable()->comment('头像');
            $table->string('site_pwd', 64)->default('')->comment('密码');
            $table->string('site_pay_pwd', 64)->default('')->comment('提现密码');
            $table->date('site_birthday')->default('1900-01-01')->comment('生日');
            $table->tinyInteger('site_sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->tinyInteger('site_state')->default(0)->comment('状态：0正常，1锁定');
            $table->tinyInteger('site_is_notice')->default(1)->comment('是否推送通知：1推，不推');
            $table->decimal('site_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('site_lng',11,6)->default(0)->comment('经度');
            $table->geometry('site_geom',4326)->nullable()->comment('geom位置数据');
            $table->string('site_province')->default('')->comment('省');
            $table->string('site_city')->default('')->comment('市');
            $table->string('site_district')->default('')->comment('区、县');
            $table->integer('site_province_id')->default(0)->comment('省id');
            $table->integer('site_city_id')->default(0)->comment('市id');
            $table->integer('site_district_id')->default(0)->comment('区县id');
            $table->string('site_address')->default('')->comment('地址');
            $table->string('site_full_address')->default('')->comment('完整地址');
            $table->integer('site_cancel_cnt')->default(0)->comment('取消工单数');
            $table->integer('site_success_cnt')->default(0)->comment('完成工单数');
            $table->integer('site_doing_cnt')->default(0)->comment('进行中的工单数');
            $table->integer('site_brokerage_percent')->default(0)->comment('抽佣百分比');
            $table->bigInteger('wx_user_id')->default(0)->comment('微信信息表ID')->index();
            $table->timestamps();
            $table->primary('id');
            $table->index('site_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sites');
	}

}
