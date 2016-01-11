<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExoCallMissed extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exo_call_missed', function(Blueprint $table) {
			$table->increments('id');
			$table->string('call_sid');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->string('call_from');
			$table->string('call_to');
			$table->string('direction');
			$table->text('recording_url');
			$table->integer('duration');
			$table->string('forwarded_from');
			$table->string('status');
			$table->string('account_sid');
			$table->string('phone_number_sid');
			$table->string('call_status');
			$table->timestamps();
		});

		Schema::create('otdr_det', function(Blueprint $table) {
			$table->increments('id');
			$table->string('location_a');
			$table->string('location_b');
			$table->string('area_a');
			$table->string('area_b');
			$table->integer('distance');
			$table->timestamps();
		});

		Schema::create('incident', function(Blueprint $table) {
			$table->increments('id');
			$table->string('ticket_no');
			$table->string('name');
			$table->string('mobile');
			$table->string('email');
			$table->text('address');
			$table->string('area');
			$table->string('requirement');
			$table->string('ticket_type_id');
			$table->string('status_id');
			$table->integer('assigned_by');
			$table->integer('assigned_to');
			$table->integer('city_id');
			$table->string('incident_id');
			$table->string('account_id');
			$table->string('crf_no');
			$table->boolean('is_active');
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
		Schema::drop('exo_call_missed');
		Schema::drop('otdr_det');
		Schema::drop('incident');
	}

}
