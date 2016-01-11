<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stock_others_in_emp', function($table) {
			$table->dropColumn('usage');
		});

		Schema::table('stock_others_in_emp', function($table) {
			$table->integer('used');
			$table->integer('damage');
			$table->integer('left_over');
		});

		Schema::table('stock_others_out_cust', function($table) {
			$table->dropColumn('usage');
			$table->dropColumn('usage_type');
		});

		Schema::table('stock_others_out_cust', function($table) {
			$table->integer('used');
		});

		Schema::table('stock_in_onu', function($table) {
			$table->dropColumn('reciver');
		});
		Schema::table('stock_in_olt', function($table) {
			$table->dropColumn('reciver');
		});
		Schema::table('stock_in_switch', function($table) {
			$table->dropColumn('reciver');
		});

		Schema::table('stock_in_router', function($table) {
			$table->dropColumn('reciver');
		});

		Schema::table('stock_in_onu', function($table) {
			$table->string('receiver');
		});
		Schema::table('stock_in_olt', function($table) {
			$table->string('receiver');
		});
		Schema::table('stock_in_switch', function($table) {
			$table->string('receiver');
		});

		Schema::table('stock_in_router', function($table) {
			$table->string('receiver');
		});

		Schema::table('stock_out_customers', function($table) {
			$table->dropColumn('usage_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stock_others_in_emp', function($table) {
			$table->string('usage');
		});


		Schema::table('stock_others_in_emp', function($table) {
			$table->dropColumn('used');
			$table->dropColumn('damage');
			$table->dropColumn('left_over');
		});

		Schema::table('stock_others_out_cust', function($table) {
			$table->string('usage');
			$table->string('usage_type');
		});

		Schema::table('stock_others_out_cust', function($table) {
			$table->dropColumn('used');
		});

		Schema::table('stock_in_onu', function($table) {
			$table->string('reciver');
		});
		Schema::table('stock_in_olt', function($table) {
			$table->string('reciver');
		});
		Schema::table('stock_in_switch', function($table) {
			$table->string('reciver');
		});

		Schema::table('stock_in_router', function($table) {
			$table->string('reciver');
		});

		Schema::table('stock_in_onu', function($table) {
			$table->dropColumn('receiver');
		});
		Schema::table('stock_in_olt', function($table) {
			$table->dropColumn('receiver');
		});
		Schema::table('stock_in_switch', function($table) {
			$table->dropColumn('receiver');
		});

		Schema::table('stock_in_router', function($table) {
			$table->dropColumn('receiver');
		});


		Schema::table('stock_out_customers', function($table) {
			$table->string('usage_type');
		});
	}

}

