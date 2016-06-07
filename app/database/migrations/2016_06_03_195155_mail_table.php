<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	Schema::create('mail_table', function(Blueprint $table)
        {	
        	$table->increments('id');
  			$table->string('message_id'); 
  			$table->string('thread_id');
  			$table->string('history_id'); 
  			$table->string('label');
  			$table->string('subject');
  			$table->string('from_mail');
  			$table->string('to_mail');
  			$table->string('snippet');
 			$table->longtext('body');
 			$table->text('attachment');
 			$table->string('time');
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
		Schema::dropIfExists('mail_table');
	}

}