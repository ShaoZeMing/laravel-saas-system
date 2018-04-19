<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMalfunctionsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('malfunctions', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('malfunction_name', 16)->default('')->comment('name');
            $table->string('malfunction_desc',250)->default('')->comment('描述');
            $table->bigInteger('cat_id')->default(0)->comment('分类ID')->index();
            $table->bigInteger('service_type_id')->default(0)->comment('服务类型ID')->index();
            $table->bigInteger('created_id')->default(0)->comment('创建者ID,0为后台系统创建')->index();
            $table->tinyInteger('malfunction_state')->default(0)->comment('0，对用户不开放，1.开放');
            $table->tinyInteger('malfunction_level')->default(1)->comment('层级');
            $table->integer('malfunction_sort')->default(0)->comment('状态：排序')->index();
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
		Schema::drop('malfunctions');
	}

}
