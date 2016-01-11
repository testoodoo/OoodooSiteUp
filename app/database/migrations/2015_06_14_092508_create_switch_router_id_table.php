<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwitchRouterIdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('switch_routers_id_det', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('cd_id');
			$table->integer('onu_id');
			$table->integer('switch_id');
			$table->integer('router_id');
			$table->string('account_id',12);
			$table->string('sign_up_employee');
			$table->string('created_by');
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
		Schema::drop('switch_routers_id_det');
	}

}
