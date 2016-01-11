<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySwitchRouters extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('switch_routers_id_det', function($table) {
			$table->integer('ht_box_id')->after('onu_id');
			$table->dropColumn('cd_id');
            $table->dropColumn('id');
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
			$table->integer('cd_id');
            $table->increments('id');
			$table->dropColumn('ht_box_id');
		});
	}

}
