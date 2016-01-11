<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncidentEtaDet extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incident_eta_det', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('incident_id');
			$table->dateTime('down_time');
			$table->dateTime('up_time');
			$table->string('remarks');
			$table->string('assigned_to');
			$table->integer('assigned_by');
			$table->timestamps();
		});

		Schema::table('otdr_det', function($table) {
			$table->integer('incident_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('otdr_det', function($table) {
			$table->dropColumn('incident_id');
		});

		Schema::drop('incident_eta_det');
	}

}
