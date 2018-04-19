<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_categories', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('商家ID');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID、就是标签');
            $table->timestamps();
            $table->index(['merchant_id','cat_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_categories');
	}

}
