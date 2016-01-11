<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('status', function($table) {
			$table->string('owner_type');
			$table->integer('owner_id');
		});

		Schema::table('messages', function($table) {
			$table->string('owner_type');
			$table->integer('owner_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('status', function($table) {
            $table->dropColumn('owner_type','owner_id');
        });

        Schema::table('messages', function($table) {
            $table->dropColumn('owner_type','owner_id');
        });
	}

}
