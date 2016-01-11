<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradeTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('activation_status', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',20);
			$table->boolean('account_creation');
			$table->date('account_creation_updated_at');
			$table->boolean('subscription_creation');
			$table->date('subscription_creation_updated_at');
			$table->boolean('subscription_activation');
			$table->date('subscription_activation_updated_at');
			$table->timestamps();
		});

		Schema::create('bill_info', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('bill_no');
			$table->integer('device_cost_id');
			$table->integer('other_charges_id');
			$table->integer('discount_id');
			$table->integer('adjustment_id');
			$table->timestamps();
		});

		Schema::create('const_val', function(Blueprint $table) {
			$table->increments('id');
			$table->float('const_name');
			$table->float('const_value');
			$table->timestamps();
		});


		Schema::create('customer_application_status', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('status_id');
			$table->integer('customer_id');
			$table->boolean('done');
			$table->timestamps();
		});


		Schema::create('device_costs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->integer('amount');
			$table->text('remarks');
			$table->boolean('is_considered');
			$table->string('for_month');
			$table->boolean('is_active');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('discounts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->integer('amount');
			$table->text('remarks');
			$table->boolean('is_considered');
			$table->string('for_month');
			$table->boolean('is_active');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('document_mapping', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('file_id');
			$table->string('document_type');
			$table->string('owner_type');
			$table->integer('owner_id');
			$table->timestamps();
		});


		Schema::create('file_uploads', function(Blueprint $table) {
			$table->increments('id');
			$table->string('file_name');
			$table->integer('document_id');
			$table->timestamps();
		});

		Schema::create('iaccount_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->string('iaccount_no');
			$table->string('isubscription_no');
			$table->string('inet_id');
			$table->timestamps();
		});


		Schema::create('internet_passwords', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->string('password',20);
			$table->timestamps();
		});


		Schema::create('new_customer_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('crf_no');
			$table->enum('status', ['Activated','Processing','Rejected']);
			$table->string('account_id',11);
			$table->timestamps();
		});

		Schema::create('new_customers', function(Blueprint $table) {
			$table->increments('id');
			$table->string('application_no');
			$table->string('request_id');
			$table->string('title');
			$table->string('first_name');
			$table->string('last_name');
			$table->text('address1');
			$table->text('address2');
			$table->text('address3');
			$table->string('city');
			$table->string('state');
			$table->integer('pincode');
			$table->string('phone');
			$table->string('email');
			$table->date('dob');
			$table->enum('status', ['M','F']);
			$table->integer('plan_code');
			$table->integer('sales_employee_id');
			$table->integer('created_by_employee_id');
			$table->timestamps();
		});

		Schema::create('other_charges', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->integer('amount');
			$table->text('remarks');
			$table->boolean('is_considered');
			$table->string('for_month');
			$table->boolean('is_active');
			$table->date('date');
			$table->timestamps();
		});

		Schema::create('plan_change_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->string('old_plan_code');
			$table->integer('used_days');
			$table->string('data_usage');
			$table->integer('old_balance');
			$table->string('new_plan_code');
			$table->integer('plan_amount');
			$table->integer('prorate_balance');
			$table->integer('prorate_cost');
			$table->integer('prorate_discount');
			$table->integer('payable_amount');
			$table->integer('rem_balance');
			$table->integer('bill_no');
			$table->timestamps();
		});

		Schema::create('pre_activation_status', function(Blueprint $table) {
			$table->increments('id');
			$table->string('crf_no');
			$table->boolean('fiber');
			$table->datetime('fiber_updated_at');
			$table->boolean('splicing');
			$table->datetime('splicing_updated_at');
			$table->boolean('feasible');
			$table->datetime('feasible_updated_at');
			$table->boolean('ethernet');
			$table->datetime('ethernet_updated_at');
			$table->boolean('hut_boxes');
			$table->datetime('hut_boxes_updated_at');
			$table->boolean('activation');
			$table->datetime('activation_updated_at');
			$table->boolean('configuration');
			$table->datetime('configuration_updated_at');
			$table->timestamps();
		});


		Schema::create('role_permission', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('role_id');
			$table->string('name');
			$table->integer('route_id');
			$table->boolean('is_active');
			$table->timestamps();
		});


		Schema::create('site_login_passwords', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->string('password');
			$table->timestamps();
		});


		Schema::create('topup_cost_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('speed');
			$table->string('data');
			$table->string('cost');
			$table->string('validity');
			$table->string('data_in_gb');
			$table->timestamps();
		});


		Schema::create('topup_details', function(Blueprint $table) {
			$table->increments('id');
			$table->string('account_id',11);
			$table->integer('topup_cost_detail_id');
			$table->timestamps();
		});

		Schema::create('route_data', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('path');
			$table->string('group');
			$table->text('description');
			$table->boolean('is_active');
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
		Schema::drop('activation_status','bill_info','const_val','customer_application_status','device_costs','discounts','document_mapping','file_uploads','iaccount_details','internet_passwords','new_customer_details','new_customers','other_charges','plan_change_details','pre_activation_status','role_permission','site_login_passwords','topup_cost_details','topup_details','route_data');
	}

}
