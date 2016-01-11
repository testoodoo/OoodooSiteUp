<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequeTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cheque_transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('cheque_no');
			$table->text('cheque_details');
			$table->integer('transaction_id');
			$table->timestamps();
		});

		Schema::table('payment_transactions', function($table) {
			$table->string('transaction_type');
			$table->string('payment_type');
			$table->text('remarks');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cheque_transactions');

		Schema::table('payment_transactions', function($table) {
			$table->dropColumn('payment_type','remarks','transaction_type');
		});
	}

}
