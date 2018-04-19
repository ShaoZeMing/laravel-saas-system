<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteWorkersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('site_workers', function(Blueprint $table) {
            $table->bigInteger('site_id')->default(0)->comment('网点ID');
            $table->bigInteger('worker_id')->default(0)->comment('师傅ID');
            $table->timestamps();
            $table->index(['site_id','worker_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('site_workers');
	}

}
