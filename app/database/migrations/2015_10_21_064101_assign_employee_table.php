<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignEmployeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ticket_update_status', function(Blueprint $table) {
			$table->increments('id');
			$table->string('call_sid');
			$table->integer('employee_identity');
			$table->integer('employee_pin_no');
			$table->string('ticket_no');
			$table->string('update_phone');
			$table->string('update_status');
			$table->string('update_employee_pin');
			$table->string('ticket_re_assign_to');
			$table->timestamps();
		});

		Schema::table('employees', function($table) {
			$table->integer('employee_pin_no');
		});

		Schema::create('ticket_callback_det', function(Blueprint $table) {
			$table->increments('id');
			$table->string('call_sid');
			$table->integer('employee_identity');
			$table->integer('employee_pin_no');
			$table->string('ticket_no');
			$table->string('cust_phone');
			$table->string('emp_phone');
			$table->timestamps();
		});

		Schema::table('cust_ticket_call_log', function($table) {
			$table->dropColumn('phone');
		});

		Schema::table('cust_ticket_call_log', function($table) {
			$table->string('phone')->after('call_sid');
		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ticket_update_status');

		Schema::drop('ticket_callback_det');

		Schema::table('employees', function($table) {
			$table->dropColumn('employee_pin_no');
		});


		Schema::table('cust_ticket_call_log', function($table) {
			$table->dropColumn('phone');
		});
		
		Schema::table('cust_ticket_call_log', function($table) {
			$table->integer('phone');
		});

		
	}

}
