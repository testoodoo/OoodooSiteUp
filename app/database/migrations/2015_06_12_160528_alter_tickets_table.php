<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTicketsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tickets', function($table) {
			$table->string('area')->after('city_id');
		});

		DB::update("ALTER TABLE const_val CHANGE const_name const_name VARCHAR(100)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tickets', function($table) {
			$table->dropColumn('area');
		});

		DB::update("ALTER TABLE const_val CHANGE const_name const_name VARCHAR(100)");
	}

}
