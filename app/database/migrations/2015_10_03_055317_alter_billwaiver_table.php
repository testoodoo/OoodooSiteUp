<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBillwaiverTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('billwaiver', function($table) {
			$table->date('waiver_start_date');
			$table->date('waiver_end_date');
			$table->integer('waiver_data');
			$table->integer('current_plan_code');
			$table->integer('waiver_plan_code');
			$table->integer('waiver_plan_days');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('billwaiver', function($table) {
			$table->dropColumn('waiver_start_date');
			$table->dropColumn('waiver_end_date');
			$table->dropColumn('waiver_data');
			$table->dropColumn('current_plan_code');
			$table->dropColumn('waiver_plan_code');
			$table->dropColumn('waiver_plan_days');
		});
	}

}
