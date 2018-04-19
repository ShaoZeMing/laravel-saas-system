<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('product_name', 32)->default('')->comment('name');
            $table->string('product_desc',250)->default('')->comment('描述');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID')->index();
            $table->bigInteger('brand_id')->default(0)->comment('品牌ID')->index();
            $table->bigInteger('standard_id')->default(0)->comment('规格ID')->index();
            $table->string('product_version')->default('')->comment('型号、编号');
            $table->tinyInteger('product_level')->default(1)->comment('层级');
            $table->tinyInteger('product_state')->default(0)->comment('0，对用户不开放，1.开放');
            $table->integer('product_sort')->default(0)->comment('状态：排序')->index();
            $table->timestamps();
            $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
