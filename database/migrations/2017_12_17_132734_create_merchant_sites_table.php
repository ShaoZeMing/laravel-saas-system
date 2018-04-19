<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantSitesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('merchant_sites', function(Blueprint $table) {
            $table->bigInteger('merchant_id')->default(0)->comment('商家ID');
            $table->bigInteger('site_id')->default(0)->comment('网点ID');
            $table->timestamps();
            $table->index(['merchant_id','site_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('merchant_sites');
	}

}
