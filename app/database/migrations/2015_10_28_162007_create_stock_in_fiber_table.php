<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockInFiberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_category', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_name');
			$table->string('brand');
			$table->string('material_type');
			$table->string('material_details');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_brand');
			$table->string('material_type');
			$table->string('total_meter');
			$table->string('total_count');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_fiber', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_brand');
			$table->integer('drum_no');
			$table->integer('start_meter');
			$table->integer('end_meter');
			$table->integer('total_meter');
			$table->integer('used');
			$table->integer('damage');
			$table->integer('left_over');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_employees', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('employee_identity');
			$table->string('material_brand');
			$table->integer('drum_no');
			$table->integer('start_meter');
			$table->integer('end_meter');
			$table->integer('total_meter');
			$table->integer('used');
			$table->integer('damage');
			$table->integer('left_over');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_ethernet', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_brand');
			$table->integer('drum_no');
			$table->integer('start_meter');
			$table->integer('end_meter');
			$table->integer('total_meter');
			$table->integer('used');
			$table->integer('damage');
			$table->integer('left_over');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_onu', function(Blueprint $table) {
			$table->increments('id');
			$table->string('onu_id');
			$table->string('material_brand');
			$table->string('srl_no');
			$table->string('mac_address');
			$table->integer('sender');
			$table->integer('reciver');
			$table->boolean('process');
			$table->boolean('wait');
			$table->boolean('damage');
			$table->boolean('complete');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_olt', function(Blueprint $table) {
			$table->increments('id');
			$table->string('olt_id');
			$table->string('material_brand');
			$table->string('srl_no');
			$table->string('mac_address');
			$table->integer('sender');
			$table->integer('reciver');
			$table->boolean('process');
			$table->boolean('wait');
			$table->boolean('damage');
			$table->boolean('complete');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_router', function(Blueprint $table) {
			$table->increments('id');
			$table->string('router_id');
			$table->string('material_brand');
			$table->string('srl_no');
			$table->string('mac_address');
			$table->integer('sender');
			$table->integer('reciver');
			$table->boolean('process');
			$table->boolean('wait');
			$table->boolean('damage');
			$table->boolean('complete');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_in_switch', function(Blueprint $table) {
			$table->increments('id');
			$table->string('switch_id');
			$table->string('material_brand');
			$table->string('srl_no');
			$table->integer('sender');
			$table->integer('reciver');
			$table->boolean('process');
			$table->boolean('wait');
			$table->boolean('damage');
			$table->boolean('complete');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_out_customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('crf_no');
			$table->string('account_id');
			$table->string('usage_type');
			$table->integer('fiber_drum_no');
			$table->integer('fiber_start_meter');
			$table->integer('fiber_end_meter');
			$table->integer('ethernet_drum_no');
			$table->integer('ethernet_start_meter');
			$table->integer('ethernet_end_meter');
			$table->string('onu_id');
			$table->string('router_id');
			$table->string('switch_id');
			$table->timestamps();
		});

		Schema::create('stock_others_out_cust', function(Blueprint $table) {
			$table->increments('id');
			$table->string('crf_no');
			$table->string('account_id');
			$table->string('usage_type');
			$table->string('material_brand');
			$table->string('usage');
			$table->string('stock_others_id');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_others_in_emp', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_brand');
			$table->string('total');
			$table->string('usage');
			$table->string('employee_identity');
			$table->string('stock_others_id');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('stock_others_det', function(Blueprint $table) {
			$table->increments('id');
			$table->string('material_brand');
			$table->string('total');
			$table->string('usage');
			$table->string('damage');
			$table->string('left_over');
			$table->date('date');
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
		Schema::drop('stock_category');
		Schema::drop('stock_in');
		Schema::drop('stock_in_fiber');
		Schema::drop('stock_in_employees');
		Schema::drop('stock_in_ethernet');
		Schema::drop('stock_in_onu');
		Schema::drop('stock_in_olt');
		Schema::drop('stock_in_router');
		Schema::drop('stock_in_switch');
		Schema::drop('stock_out_customers');
		Schema::drop('stock_others_out_cust');
		Schema::drop('stock_others_in_emp');
		Schema::drop('stock_others_det');

	}

}