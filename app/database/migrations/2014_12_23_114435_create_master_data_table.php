<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('master_data', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('type');
			$table->boolean('active');
			$table->timestamps();
		});

		MasterData::create(array('name' => 'New Connection', 'type' => 'ticket_type','active' => 1));
		MasterData::create(array('name' => 'Complaint', 'type' => 'ticket_type','active' => 1));

		MasterData::create(array('name' => 'Open', 'type' => 'ticket_status','active' => 1));
		MasterData::create(array('name' => 'Closed', 'type' => 'ticket_status','active' => 1));
		MasterData::create(array('name' => 'Processing', 'type' => 'ticket_status','active' => 1));
		MasterData::create(array('name' => 'Invalid', 'type' => 'ticket_status','active' => 1));
		MasterData::create(array('name' => 'Trash', 'type' => 'ticket_status','active' => 1));

		MasterData::create(array('name' => 'Urgent', 'type' => 'ticket_priority','active' => 1));
		MasterData::create(array('name' => 'High', 'type' => 'ticket_priority','active' => 1));
		MasterData::create(array('name' => 'Medium', 'type' => 'ticket_priority','active' => 1));
		MasterData::create(array('name' => 'Low', 'type' => 'ticket_priority','active' => 1));

		MasterData::create(array('name' => 'Chennai', 'type' => 'city','active' => 1));

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('master_data');
	}

}
