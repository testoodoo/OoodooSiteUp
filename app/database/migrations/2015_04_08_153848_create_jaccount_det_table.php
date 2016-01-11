<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJaccountDetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jaccount_det', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',12);
			$table->integer('jaccount_no');
			$table->timestamps();
		});

		Schema::table('plan_cost_det', function($table) {
			$table->integer('jplan_code');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jaccount_det');
		Schema::table('plan_cost_det', function($table) {
            $table->dropColumn('jplan_code');
        });
	}

}
