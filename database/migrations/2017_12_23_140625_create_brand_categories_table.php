<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('brand_categories', function(Blueprint $table) {
            $table->bigInteger('brand_id')->default(0)->comment('网点ID');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID、就是标签');
            $table->timestamps();
            $table->index(['brand_id','cat_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('brand_categories');
	}

}
