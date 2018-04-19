<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table) {
            $table->bigInteger('id');
            $table->string('filename', 16)->default('')->comment('name');
            $table->string('file_ext', 32)->default('')->comment('后缀');
            $table->string('file_size', 16)->default('')->comment('大小');
            $table->string('file_type',12)->default('image')->comment('状态：face,image');
            $table->string('b_path')->default('')->comment('原图路径');
            $table->string('m_path')->default('')->comment('中图路径');
            $table->string('s_path')->default('')->comment('小图路径');
            $table->bigInteger('uploadable_id')->default(0)->comment('关联对象ID');
            $table->string('uploadable_type',64)->default('')->comment('关联对象');
            $table->tinyInteger('image_type')->default(0)->comment('状态：0未知，1创建，2检测，3完成');
            $table->timestamps();
            $table->primary('id');
            $table->index(['uploadable_id','uploadable_type']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('files');
	}

}
