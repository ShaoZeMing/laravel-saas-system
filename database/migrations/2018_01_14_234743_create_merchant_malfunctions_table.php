<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantMalfunctionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_malfunctions', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('企业ID');
            $table->bigInteger('malfunction_id')->default(0)->comment('故障ID');
            $table->timestamps();
            $table->index(['merchant_id','malfunction_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_malfunctions');
	}

}
