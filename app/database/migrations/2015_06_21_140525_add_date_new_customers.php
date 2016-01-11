<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateNewCustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('new_customers', function($table) {
			$table->date('application_date')->after('plan_code');
		});

		Schema::table('bill_det', function($table) {
			$table->integer('plan_code')->after('cust_current_plan');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('new_customers', function($table) {
			$table->dropColumn('application_date');
		});
		Schema::table('bill_det', function($table) {
			$table->dropColumn('plan_code');
		});
	}

}
