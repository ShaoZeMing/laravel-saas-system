<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStandardsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('standards', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('standard_name', 32)->default('')->comment('name');
            $table->string('standard_desc',250)->default('')->comment('描述');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID')->index();
            $table->tinyInteger('standard_state')->default(0)->comment('0，对用户不开放，1.开放');
            $table->integer('standard_sort')->default(0)->comment('状态：排序')->index();
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
		Schema::drop('standards');
	}

}
