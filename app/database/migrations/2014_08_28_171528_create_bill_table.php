<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bills', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id');
			$table->integer('bill_no')->unique();
			$table->string('month');
			$table->integer('total_charges');
			$table->string('status');
			$table->integer('amount_paid');
			$table->string('customer_current_plan');
			$table->date('bill_date');
			$table->date('bill_start_date');
			$table->date('bill_end_date');
			$table->date('due_date');
			$table->integer('security_deposit');
			$table->integer('previous_balance');
			$table->integer('last_payment');
			$table->integer('adjustments');
			$table->integer('current_rental');
			$table->integer('device_cost');
			$table->integer('one_time_charges');
			$table->integer('discount');
			$table->integer('other_charges');
			$table->integer('sub_total');
			$table->integer('service_tax');
			$table->integer('amount_before_due_date');
			$table->integer('amount_after_due_date');
			$table->boolean('active')->default(true);
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
		Schema::drop('bills');
	}

}
