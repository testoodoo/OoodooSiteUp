<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActivationDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activation_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',12);
			$table->dateTime('expiry_date');
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
		Schema::drop('activation_details');
	}

}
