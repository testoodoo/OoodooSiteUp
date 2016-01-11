<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('ticket_type');
			$table->integer('open');
			$table->integer('close');
			$table->integer('processing');
			$table->integer('invaild');
			$table->dateTime('ticket_date');
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
		Schema::drop('ticket_details');
	}

}
