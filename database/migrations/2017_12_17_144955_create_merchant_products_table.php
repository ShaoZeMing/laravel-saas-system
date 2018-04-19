<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantProductsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_products', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('商家ID');
            $table->bigInteger('product_id')->default(0)->comment('产品ID');
            $table->timestamps();
            $table->index(['merchant_id','product_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_products');
	}

}
