<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaymentDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payment_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('status');
			$table->integer('cheque');
			$table->integer('card');
			$table->integer('cash');
			$table->integer('cash_online');
			$table->integer('cash_offline');
			$table->integer('cash_online_anpay');
			$table->integer('cash_online_acpay');
			$table->string('for_month');
			$table->timestamps();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payment_details');
	}

}
