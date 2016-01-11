<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataUsageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_usage', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id');
			$table->integer('user_id');
			$table->string('month');
			$table->integer('bytes_consumed');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_usage');
	}

}
