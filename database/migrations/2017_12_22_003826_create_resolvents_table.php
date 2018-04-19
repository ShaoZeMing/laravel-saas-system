<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResolventsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resolvents', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('malfunction_id')->default(0)->comment('故障ID');
            $table->string('resolvent_name', 16)->default('')->comment('name');
            $table->text('resolvent_desc')->default('')->comment('描述');
            $table->string('resolvent_url')->default('')->comment('视屏地址');
            $table->tinyInteger('resolvent_state')->default(0)->comment('0，不开放，1.开放');
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
		Schema::drop('resolvents');
	}

}
