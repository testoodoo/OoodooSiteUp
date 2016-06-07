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
  			$table->string('thread_id');
  			$table->string('ticket_no'); 
  			$table->string('status');
  			$table->string('assign_to');
  			$table->string('remarks');
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
		Schema::dropIfExists('create_ticket_status_table');
	}

}