<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillWaiverTable extends Migration {

	public function up()
	{
		Schema::create('billwaiver', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',13);
			$table->integer('amount');
			$table->text('remarks');
			$table->boolean('is_considered');
			$table->string('for_month');
			$table->boolean('is_active');
			$table->date('date');
			$table->timestamps();
		});

		Schema::table('new_customers', function($table) {
			$table->string('remarks');
		});

	}

	public function down()
	{
		Schema::drop('billwaiver');

		Schema::table('new_customers', function($table) {
			$table->dropColumn('remarks');
		});
	}

}
