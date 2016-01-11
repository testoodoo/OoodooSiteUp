<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeasibleDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feasible_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('area');
			$table->integer('fiber');
			$table->integer('ethernet');
			$table->integer('splicing');
			$table->integer('hut_boxes');
			$table->integer('configuration');
			$table->integer('cust_count_in_area');
			$table->dateTime('feasible_date');
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
		Schema::drop('feasible_details');
	}

}
