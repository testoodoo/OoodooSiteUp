<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketStatusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('create_ticket_status_table', function(Blueprint $table)
        {
  			$table->increments('id');
  			$table->string('ticket_id'); 
  			$table->string('thread_id');
  			$table->string('message'); 
  			$table->string('updated_by');
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
		Schema::drop('create_tiket_status_table');		
	}

}
