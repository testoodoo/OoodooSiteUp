<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaLatLong extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lat_long_area', function(Blueprint $table) {
			$table->increments('id');
			$table->string('area');
			$table->double('lat',15,8);
			$table->double('long',15,8);
			$table->timestamps();
		});

		Schema::create('lat_long_distance', function(Blueprint $table) {
			$table->increments('id');
			$table->string('employee_identity');
			$table->string('current_location');
			$table->string('to_location');
			$table->double('to_distance',15,8);
			$table->timestamps();
		});

		Schema::create('ticket_current_status', function(Blueprint $table) {
			$table->increments('id');
			$table->string('employee_identity');
			$table->string('location');
			$table->double('distance',15,8);
			$table->string('ticket_no');
			$table->string('operation');
			$table->timestamps();
		});


		Schema::table('cust_ticket_call_log', function($table) {
			$table->string('call_sid')->after('id');
		});

		Schema::table('employees', function($table) {
			$table->boolean('is_onduty');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lat_long_area');
		Schema::drop('lat_long_distance');
		Schema::drop('ticket_current_status');
		
		Schema::table('cust_ticket_call_log', function($table) {
			$table->dropColumn('call_sid');
		});

		Schema::table('employees', function($table) {
			$table->dropColumn('is_onduty');
		});
	}

}
