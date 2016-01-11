<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketCallLogDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets_call_log', function(Blueprint $table) {
			$table->increments('id');
			$table->string('callsid');
    		$table->integer('from');
    		$table->integer('to');
    		$table->string('direction');
    		$table->string('dailcallduration');
    		$table->dateTime('starttime');
    		$table->dateTime('endtime');
    		$table->string('calltype');
    		$table->integer('digits');
    		$table->string('dialwhomnumber'); 
    		$table->string('created');
    		$table->integer('flow_id');
    		$table->integer('tenant_id');
    		$table->integer('callfrom');
    		$table->integer('callto');
    		$table->string('forwardedfrom');
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
		Schema::drop('tickets_call_log');
	}

}
