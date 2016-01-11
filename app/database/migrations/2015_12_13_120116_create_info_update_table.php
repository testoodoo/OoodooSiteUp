<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoUpdateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_info', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ticket_id');
			$table->string('message_type');
			$table->string('message');
			$table->string('msg_info');
			$table->boolean('updation');
			$table->string('updated_by');
			$table->timestamps();
		});

		Schema::table('incident_eta_det', function($table) {
			$table->integer('hour');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('incident_eta_det', function($table) {
			$table->dropColumn('hour');
		});

		Schema::drop('ticket_info');
	}

}
