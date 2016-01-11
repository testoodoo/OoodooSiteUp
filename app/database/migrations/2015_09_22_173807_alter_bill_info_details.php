<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillInfoDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('discounts', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('device_costs', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('other_charges', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('plan_change_details', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('topup_details', function($table) {
			$table->dropColumn('account_id');
		});

		Schema::table('discounts', function($table) {
			$table->string('account_id',13)->after('id');
		});
		Schema::table('device_costs', function($table) {
			$table->string('account_id',13)->after('id');
		});
		Schema::table('other_charges', function($table) {
			$table->string('account_id',13)->after('id');
		});
		Schema::table('plan_change_details', function($table) {
			$table->string('account_id',13)->after('id');
		});
		Schema::table('topup_details', function($table) {
			$table->string('account_id',13)->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('discounts', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('device_costs', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('other_charges', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('plan_change_details', function($table) {
			$table->dropColumn('account_id');
		});
		Schema::table('topup_details', function($table) {
			$table->dropColumn('account_id');
		});

		Schema::table('discounts', function($table) {
			$table->string('account_id');
		});
		Schema::table('device_costs', function($table) {
			$table->string('account_id');
		});
		Schema::table('other_charges', function($table) {
			$table->string('account_id');
		});
		Schema::table('plan_change_details', function($table) {
			$table->string('account_id');
		});
		Schema::table('topup_details', function($table) {
			$table->string('account_id');
		});
	}

}
