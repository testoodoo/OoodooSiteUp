<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsCallLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets_call_log', function($table) {
			$table->dropColumn('from');
			$table->dropColumn('to');
			$table->dropColumn('callfrom');
			$table->dropColumn('callto');

		});

		Schema::table('tickets_call_log', function($table) {
			$table->string('to')->after('callsid');
			$table->string('from')->after('callsid');
			$table->string('callto')->after('tenant_id');
			$table->string('callfrom')->after('tenant_id');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets_call_log', function($table) {
			$table->dropColumn('from');
			$table->dropColumn('to');
			$table->dropColumn('callfrom');
			$table->dropColumn('callto');

		});

		Schema::table('tickets_call_log', function($table) {
			$table->integer('from');
			$table->integer('to');
			$table->integer('callfrom');
			$table->integer('callto');

		});
	}

}
