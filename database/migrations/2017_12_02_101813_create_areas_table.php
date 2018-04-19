<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('areas', function(Blueprint $table) {
            $table->integer('id');
            $table->string('name', 20)->default('')->comment('地址名称');
            $table->integer('parent_id')->default(0)->comment('上级ID')->index();
            $table->primary('id');
		});
		$sql = file_get_contents(database_path('areas.sql'));
        \Illuminate\Support\Facades\DB::select($sql);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('areas');
	}

}
