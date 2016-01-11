<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('payment_details', function($table) {
			$table->integer('cheque_amt');
			$table->integer('card_amt');
			$table->integer('cash_offline_amt');
			$table->integer('cash_online_anpay_amt');
			$table->integer('cash_online_acpay_amt');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('payment_details', function($table) {
			$table->dropColumn('cheque_amt');
			$table->dropColumn('card_amt');
			$table->dropColumn('cash_offline_amt');
			$table->dropColumn('cash_online_anpay_amt');
			$table->dropColumn('cash_online_acpay_amt');
		});
	}

}
