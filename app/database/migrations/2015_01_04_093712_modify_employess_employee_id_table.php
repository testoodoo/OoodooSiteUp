<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyEmployessEmployeeIdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employees', function($table) {
			DB::update("ALTER TABLE employees CHANGE employee_identity employee_identity INT(11)");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('employees', function($table) {
            DB::update("ALTER TABLE employees CHANGE employee_identity employee_identity VARCHAR(55)");
        });
	}

}
