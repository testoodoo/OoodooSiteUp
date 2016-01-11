<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPreActivationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pre_activation_status', function($table) {
			$table->string('assign_to_fiber');
			$table->string('assign_to_splicing');
			$table->string('assign_to_hut_boxes');
			$table->string('assign_to_ethernet');
			$table->string('assign_to_configuration');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pre_activation_status', function($table) {
			$table->dropColumn('assign_to_fiber');
			$table->dropColumn('assign_to_splicing');
			$table->dropColumn('assign_to_hut_boxes');
			$table->dropColumn('assign_to_ethernet');
			$table->dropColumn('assign_to_configuration');
		});
	}

}
