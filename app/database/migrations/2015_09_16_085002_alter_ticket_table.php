<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function($table) {
			$table->dropColumn('belonging_id');
			$table->dropColumn('belonging_type');
			$table->dropColumn('owner_id');
			$table->dropColumn('owner_type');
			$table->string('assigned_by');
			$table->string('assigned_to');
		});

		Schema::table('status', function($table) {
			$table->dropColumn('owner_id');
			$table->dropColumn('owner_type');
			$table->string('updated_by');
		});

		Schema::table('messages', function($table) {
			$table->dropColumn('owner_id');
			$table->dropColumn('owner_type');
			$table->string('updated_by');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets', function($table) {
			$table->integer('belonging_id');
			$table->string('belonging_type');
			$table->integer('owner_id');
			$table->string('owner_type');
			$table->dropColumn('assigned_by');
			$table->dropColumn('assigned_to');
		});

		Schema::table('status', function($table) {
			$table->integer('owner_id');
			$table->string('owner_type');
			$table->dropColumn('updated_by');
		});

		Schema::table('messages', function($table) {
			$table->integer('owner_id');
			$table->string('owner_type');
			$table->dropColumn('updated_by');
		});


	}

}
