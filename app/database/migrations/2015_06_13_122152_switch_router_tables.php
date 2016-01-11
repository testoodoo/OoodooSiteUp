<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SwitchRouterTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('switch_routers_det', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('device_id');
			$table->string('catagory_type');
			$table->string('device_type');
			$table->string('mac_address');
			$table->integer('srl_no');
			$table->string('manufacture');
			$table->string('ip_address');
			$table->string('remarks');
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
		Schema::drop('switch_routers_det');
	}

}
