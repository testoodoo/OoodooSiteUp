<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMerchantId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{  
		Schema::table('payment_transactions', function($table) {
			$table->string('merchant_id')->after('bill_no');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('payment_transactions', function($table) {
			$table->dropColumn('merchant_id');
		});
	}

}
