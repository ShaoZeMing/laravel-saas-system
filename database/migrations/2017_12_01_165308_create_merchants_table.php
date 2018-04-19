<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Shaozeming\LumenPostgis\Schema\Blueprint;

class CreateMerchantsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchants', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('merchant_mobile', 12)->default('')->comment('电话');
            $table->string('merchant_name', 16)->default('')->comment('姓名');
            $table->string('merchant_nickname', 32)->default('')->comment('公司名称');
            $table->string('merchant_face')->nullable()->comment('头像');
            $table->string('merchant_pwd', 64)->default('')->comment('密码');
            $table->string('merchant_pay_pwd', 64)->default('')->comment('提现密码');
            $table->date('merchant_birthday')->default('1900-01-01')->comment('生日');
            $table->tinyInteger('merchant_sex')->default(0)->comment('状态：0未知，1男，2女');
            $table->tinyInteger('merchant_state')->default(0)->comment('状态：0正常，1锁定');
            $table->tinyInteger('merchant_is_notice')->default(1)->comment('是否推送通知：1推，不推');
            $table->decimal('merchant_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('merchant_lng',11,6)->default(0)->comment('经度');
            $table->geometry('merchant_geom',4326)->nullable()->comment('geom位置数据');
            $table->string('merchant_province')->default('')->comment('省');
            $table->string('merchant_city')->default('')->comment('市');
            $table->string('merchant_district')->default('')->comment('区、县');
            $table->string('merchant_address')->default('')->comment('地址');
            $table->integer('merchant_province_id')->default(0)->comment('省id');
            $table->integer('merchant_city_id')->default(0)->comment('市id');
            $table->integer('merchant_district_id')->default(0)->comment('区县id');
            $table->string('merchant_full_address')->default('')->comment('完整地址');
            $table->integer('merchant_cancel_cnt')->default(0)->comment('取消工单数');
            $table->integer('merchant_success_cnt')->default(0)->comment('完成工单数');
            $table->integer('merchant_doing_cnt')->default(0)->comment('进行中的工单数');
            $table->integer('merchant_brokerage_percent')->default(0)->comment('抽佣百分比');
            $table->bigInteger('wx_user_id')->default(0)->comment('微信信息表ID')->index();
            $table->timestamps();
            $table->primary('id');
            $table->index('merchant_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchants');
	}

}
