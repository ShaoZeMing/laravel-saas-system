<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBillsTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_bills', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->bigInteger('user_id')->default(0)->comment('关联ID')->index();
            $table->integer('balance')->default(0)->comment('余额总额');
            $table->integer('freeze')->default(0)->comment('冻结金额');
            $table->integer('available')->default(0)->comment('可用余额');
            $table->integer('coupon')->default(0)->comment('红包金额');
            $table->integer('paid')->default(0)->comment('累积支出');
            $table->integer('income')->default(0)->comment('累积收入');
            $table->integer('amount')->default(0)->comment('本流水金额');
            $table->bigInteger('billable_id')->default(0)->comment('关联对象ID');
            $table->string('billable_type',64)->default('')->comment('关联对象');
            $table->tinyInteger('biz_type')->default(0)->comment('业务类型 -1支出 1充值 -2 冻结 2 解冻 3退款 5线下充值');
            $table->string('biz_comment',20)->default('')->comment('业务类型说明');
            $table->timestamps();
            $table->primary('id');
            $table->index(['billable_id','billable_type']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_bills');
	}

}
