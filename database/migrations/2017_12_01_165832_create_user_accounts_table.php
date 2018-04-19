<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_accounts', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->integer('balance')->default(0)->comment('余额总额');
            $table->integer('freeze')->default(0)->comment('冻结金额');
            $table->integer('available')->default(0)->comment('可用余额');
            $table->integer('coupon')->default(0)->comment('红包金额');
            $table->integer('paid')->default(0)->comment('累积支出');
            $table->integer('income')->default(0)->comment('累积收入');
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
		Schema::drop('user_accounts');
	}

}
