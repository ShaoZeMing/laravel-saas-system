<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('customer_mobile', 12)->default('')->comment('电话');
            $table->string('customer_name', 16)->default('')->comment('姓名');
            $table->decimal('customer_lat',11,6)->default(0)->comment('纬度');
            $table->decimal('customer_lng',11,6)->default(0)->comment('经度');
            $table->geometry('customer_geom',4326)->nullable()->comment('geom位置数据');
            $table->string('customer_province')->default('')->comment('省');
            $table->string('customer_city')->default('')->comment('市');
            $table->string('customer_district')->default('')->comment('区、县');
            $table->integer('customer_province_id')->default(0)->comment('省id');
            $table->integer('customer_city_id')->default(0)->comment('市id');
            $table->integer('customer_district_id')->default(0)->comment('区县id');
            $table->string('customer_address')->default('')->comment('地址');
            $table->string('customer_full_address')->default('')->comment('完整地址');
            $table->timestamps();
            $table->primary('id');
            $table->index('customer_mobile');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
