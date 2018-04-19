<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantStandardsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_standards', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('商家ID');
            $table->bigInteger('standard_id')->default(0)->comment('规格ID');
            $table->timestamps();
            $table->index(['merchant_id','standard_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_standards');
	}

}
