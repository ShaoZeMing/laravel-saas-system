<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMalfunctionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_malfunctions', function(Blueprint $table) {
            $table->bigInteger('product_id')->default(0)->comment('产品ID');
            $table->bigInteger('malfunction_id')->default(0)->comment('故障ID');
            $table->timestamps();
            $table->index(['product_id','malfunction_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_malfunctions');
	}

}
