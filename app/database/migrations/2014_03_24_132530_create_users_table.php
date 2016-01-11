<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('first_name')->index();
			$table->string('last_name')->index();
			$table->string('country');
			$table->string('email')->unique();
			$table->string('password');
			$table->date('dob')->nullable();
			$table->string('mobile')->index();
			$table->string('occupation');
			$table->string('website_url');
			$table->text('about_me');
			$table->boolean('active')->default(true);
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
		Schema::drop('users');
	}

}
