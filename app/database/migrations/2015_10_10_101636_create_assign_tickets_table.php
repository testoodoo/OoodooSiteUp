<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assign_tickets', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ticket_id');
			$table->integer('ticket_no');
			$table->text('remarks');
			$table->integer('assigned_to');
			$table->integer('assigned_by');
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
		Schema::drop('assign_tickets');
	}

}
