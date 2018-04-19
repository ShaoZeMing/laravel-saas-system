<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_types', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('service_type_name', 16)->default('')->comment('name');
            $table->string('service_type_desc',250)->default('')->comment('描述');
            $table->tinyInteger('service_type_state')->default(0)->comment('0，对用户不开放，1.开放');
            $table->tinyInteger('service_type_level')->default(1)->comment('层级');
            $table->bigInteger('created_id')->default(0)->comment('创建者ID,0为后台系统创建')->index();
            $table->integer('service_type_sort')->default(0)->comment('状态：排序')->index();
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
		Schema::drop('service_types');
	}

}
