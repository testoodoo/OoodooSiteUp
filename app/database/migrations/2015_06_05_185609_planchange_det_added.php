<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlanchangeDetAdded extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('planchange_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',12);
			$table->string('plan_name');
			$table->integer('plan_code');
			$table->date('plan_change_date');
			$table->integer('request_id');
			$table->string('remarks');
			$table->string('status');
			$table->string('error');
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
		Schema::drop('planchange_details');
	}

}
