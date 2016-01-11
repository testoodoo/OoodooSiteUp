<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToEmployeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('employees', function($table) {
			$table->string('father_husband_name');
			$table->string('qualification');
			$table->date('dob');
			$table->text('current_address');
			$table->text('permanent_address');
			$table->string('employee_id');
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
            $table->dropColumn('father_husband_name','qualification','dob','current_address','permanent_address','employee_id');
        });
	}

}
