<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CardTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('card_transactions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('transaction_id',20);
			$table->string('terminal_id',20);
			$table->string('merchant_id',25);
			$table->integer('invoice_id',false,true)->length(10);
			$table->integer('card_last_four_digit',false,true)->length(4);
			$table->string('transaction_details');
			$table->timestamps();

		});
	}

	public function integer($column, $autoIncrement = false, $unsigned = false)
		 {
		  return $this->addColumn('integer', $column, compact('autoIncrement', 'unsigned'));
		 }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('card_transactions');
	}

}
