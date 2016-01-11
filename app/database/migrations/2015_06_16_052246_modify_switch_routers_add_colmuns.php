<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySwitchRoutersAddColmuns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('switch_routers_id_det', function($table) {
			$table->increments('cd_id')->after('onu_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('switch_routers_id_det', function($table) {
			$table->dropColumn('cd_id');
		});
	}

}
