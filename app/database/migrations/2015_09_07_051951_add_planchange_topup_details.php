<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanchangeTopupDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plan_change_details', function($table) {
			$table->integer('other_charges_id')->after('payable_amount');
			$table->integer('last_amount_before_due_date');
			$table->integer('last_plan_code');
			$table->integer('last_bill_no');
		});

		Schema::create('top_up_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id');
			$table->integer('other_charges_id');
			$table->integer('old_plan_code');
			$table->string('data_usage');
			$table->string('topup_id');
			$table->string('speed');
			$table->integer('data');
			$table->integer('cost');
			$table->integer('bill_no');
			$table->string('desc');
			$table->timestamps();
		});

		Schema::table('topup_details', function($table) {
			$table->string('plan');
			$table->integer('plan_code');
			$table->integer('jaccount_no');
			$table->date('topup_date');
			$table->string('data_usage');
			$table->string('topup_data');
			$table->string('status');
			$table->string('error');
			$table->dropColumn('topup_cost_detail_id');
		});

		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('plan_change_details', function($table) {
			$table->dropColumn('other_charges_id');
			$table->dropColumn('last_amount_before_due_date');
			$table->dropColumn('last_plan_code');
			$table->dropColumn('last_bill_no');
		});

		Schema::table('topup_details', function($table) {
			$table->dropColumn('plan');
			$table->dropColumn('plan_code');
			$table->dropColumn('jaccount_no');
			$table->dropColumn('topup_date');
			$table->dropColumn('data_usage');
			$table->dropColumn('topup_data');
			$table->dropColumn('status');
			$table->dropColumn('error');
			$table->integer('topup_cost_detail_id');
		});

		Schema::drop('top_up_details');

	}

}
