<?php

//use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Shaozeming\LumenPostgis\Schema\Blueprint;

class CreateOrdersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->bigInteger('id')->comment('主键id');
            $table->bigInteger('order_no')->default(0)->comment('工单号')->index();
            $table->tinyInteger('state')->default(0)->comment('订单状态')->index();
            $table->tinyInteger('order_type')->default(0)->comment('0 保内 1 保外');
            $table->tinyInteger('service_type')->default(0)->comment('0 安装 1 维修');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID')->index();
            $table->string('cat_name',32)->default('')->comment('分类名称');
            $table->bigInteger('brand_id')->default(0)->comment('品牌ID')->index();
            $table->string('brand_name',32)->default('')->comment('品牌');
            $table->bigInteger('product_id')->default(0)->comment('产品ID')->index();
            $table->string('product_name',32)->default('')->comment('产品');
            $table->bigInteger('malfunction_id')->default(0)->comment('故障ID,如果故障ID=0 则需要检测');
            $table->string('malfunction_name',32)->default('')->comment('故障名称');
            $table->integer('price')->default(0)->comment('工单价格');
            $table->integer('pay_price')->default(0)->comment('支付价格');
            $table->string('order_desc',255)->default('')->comment('工单描述');
            $table->char('verify_code',6)->default('')->comment('校验码');
            $table->tinyInteger('pay_state')->default(0)->comment('支付状态：0 未支付 1 支付');
            $table->bigInteger('createdable_id')->default(0)->comment('创建者关联对象ID');
            $table->string('createdable_type',64)->default('')->comment('创建者关联对象');
            $table->string('created_name',64)->default('')->comment('创建者名称');
            $table->string('created_logo',255)->default('')->comment('创建者头像');
            $table->integer('merchant_follow_id')->default(0)->comment('企业跟单人员id')->index();
            $table->bigInteger('site_id')->default(0)->comment('网点ID')->index();
            $table->string('site_name',64)->default('')->comment('网点名称');
            $table->integer('site_follow_id')->default(0)->comment('企业跟单人员id')->index();
            $table->bigInteger('worker_id')->default(0)->comment('师傅ID')->index();
            $table->string('worker_name',64)->default('')->comment('师傅名称');
            $table->string('worker_mobile', 12)->default('')->comment('师傅电话');
            $table->string('worker_logo',255)->default('')->comment('师傅头像');
            $table->string('connect_mobile', 12)->default('')->comment('联系电话');
            $table->string('connect_name', 16)->default('')->comment('联系人');
            $table->string('province')->default('')->comment('省');
            $table->string('city')->default('')->comment('市');
            $table->string('district')->default('')->comment('区、县');
            $table->string('address')->default('')->comment('地址');
            $table->integer('province_id')->default(0)->comment('省id');
            $table->integer('city_id')->default(0)->comment('市id');
            $table->integer('district_id')->default(0)->comment('区县id');
            $table->string('full_address')->default('')->comment('完整地址');
            $table->decimal('order_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('order_lng',11,6)->default(0)->comment('经度');
            $table->geometry('geom',4326)->comment('geom位置数据');
            $table->string('order_source',10)->default('wx')->comment('下单来源：wx：微信；web:网站;app:APP客户端。');
            $table->timestamp('accepted_at')->default('2000-01-01 00:00:00')->comment('接单时间');
            $table->timestamp('booked_at')->default('2000-01-01 00:00:00')->comment('预约时间');
            $table->timestamp('inspected_at')->default('2000-01-01 00:00:00')->comment('检测时间');
            $table->timestamp('canceled_at')->default('2000-01-01 00:00:00')->comment('取消时间');
            $table->timestamp('finished_at')->default('2000-01-01 00:00:00')->comment('完成时间');
            $table->timestamp('confirmed_at')->default('2000-01-01 00:00:00')->comment('确认时间');
            $table->string('canceled_desc',255)->default('')->comment('取消原因');
            $table->string('finished_desc',255)->default('')->comment('完成工单说明');
            $table->string('inspected_desc',255)->default('')->comment('检测结果说明');
            $table->timestamps();
            $table->primary('id');
            $table->index(['createdable_id','createdable_type']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
