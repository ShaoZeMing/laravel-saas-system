<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantServiceTypesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_service_types', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('企业ID');
            $table->bigInteger('service_type_id')->default(0)->comment('服务类型ID');
            $table->timestamps();
            $table->index(['merchant_id','service_type_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_service_types');
	}

}
