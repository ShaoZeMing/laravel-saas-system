<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAppsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_apps', function(Blueprint $table) {
            $table->string('device_id', 32)->default('')->comment('后缀');
            $table->string('device_os', 16)->default('')->comment('大小');
            $table->string('is_login    ',12)->default('image')->comment('状态：face,image');
            $table->string('b_path')->default('')->comment('原图路径');
            $table->string('m_path')->default('')->comment('中图路径');
            $table->string('s_path')->default('')->comment('小图路径');
            $table->bigInteger('userable_id')->default(0)->comment('关联对象ID');
            $table->string('userable_type',64)->default('')->comment('关联对象');
            $table->timestamps();
            $table->index(['userable_id','userable_type']);

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_apps');
	}

}
