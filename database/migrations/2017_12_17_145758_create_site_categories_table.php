<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_categories', function(Blueprint $table) {
            $table->bigInteger('site_id')->default(0)->comment('网点ID');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID、就是标签');
            $table->timestamps();
            $table->index(['site_id','cat_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_categories');
	}

}
