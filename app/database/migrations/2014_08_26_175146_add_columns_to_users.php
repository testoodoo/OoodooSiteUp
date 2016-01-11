<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
			$table->string('account_no');
			$table->string('account_id');
			$table->text('address');
			$table->string('city');
			$table->string('state');
			$table->integer('pincode');
			$table->string('gender');
			$table->integer('i_account_no');
			$table->integer('is_old_customer')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table) {
            $table->dropColumn('account_no');
			$table->dropColumn('account_id');
			$table->dropColumn('address');
			$table->dropColumn('city');
			$table->dropColumn('state');
			$table->dropColumn('pincode');
			$table->dropColumn('gender');
			$table->dropColumn('i_account_no');
			$table->dropColumn('is_old_customer');
        });
	}

}
