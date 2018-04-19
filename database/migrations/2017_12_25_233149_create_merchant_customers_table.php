<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantCustomersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_customers', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('产品ID');
            $table->bigInteger('customer_id')->default(0)->comment('故障ID');
            $table->timestamps();
            $table->index(['merchant_id','customer_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_customers');
	}

}
