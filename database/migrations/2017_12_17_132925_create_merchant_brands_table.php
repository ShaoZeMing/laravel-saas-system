<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantBrandsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_brands', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('商家ID');
            $table->bigInteger('brand_id')->default(0)->comment('品牌ID');
            $table->timestamps();
            $table->index(['merchant_id','brand_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_brands');
	}

}
