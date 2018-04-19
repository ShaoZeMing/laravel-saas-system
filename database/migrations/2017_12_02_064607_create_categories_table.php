<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('cat_name', 32)->default('')->comment('name');
            $table->string('cat_desc',250)->default('')->comment('描述');
            $table->bigInteger('cat_parent_id')->default(0)->comment('父级ID')->index();
            $table->bigInteger('created_id')->default(0)->comment('创建者ID,0为后台系统创建')->index();
            $table->tinyInteger('cat_level')->default(1)->comment('层级');
            $table->tinyInteger('cat_state')->default(0)->comment('0，对用户不开放，1.开放');
            $table->integer('cat_sort')->default(0)->comment('状态：排序')->index();
            $table->string('cat_logo')->nullable()->comment('头像');
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
		Schema::drop('categories');
	}

}
