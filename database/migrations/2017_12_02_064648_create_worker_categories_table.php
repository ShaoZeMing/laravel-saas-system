<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('worker_categories', function(Blueprint $table) {
            $table->bigInteger('worker_id')->default(0)->comment('师傅ID');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID、就是标签');
            $table->timestamps();
            $table->index(['worker_id','cat_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('worker_categories');
	}

}
