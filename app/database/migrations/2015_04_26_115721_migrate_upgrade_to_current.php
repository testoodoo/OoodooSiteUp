<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateUpgradeToCurrent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up() {

		var_dump("running cust_det migration ................");
		//First MIgrate the cust_det Table
		DB::update("ALTER TABLE cust_det CHANGE Account_No account_no INT(11)");
		DB::update("ALTER TABLE cust_det CHANGE Account_ID account_id VARCHAR(12)");
		DB::update("ALTER TABLE cust_det CHANGE Title title VARCHAR(8)");
		DB::update("ALTER TABLE cust_det CHANGE First_Name first_name VARCHAR(25)");
		DB::update("ALTER TABLE cust_det CHANGE Last_Name last_name VARCHAR(25)");
		DB::update("ALTER TABLE cust_det CHANGE Email email VARCHAR(40)");
		DB::update("ALTER TABLE cust_det CHANGE Address1 address1 VARCHAR(50)");
		DB::update("ALTER TABLE cust_det CHANGE Address2 address2 VARCHAR(50)");
		DB::update("ALTER TABLE cust_det CHANGE Address3 address3 VARCHAR(50)");
		DB::update("ALTER TABLE cust_det CHANGE City city VARCHAR(30)");
		DB::update("ALTER TABLE cust_det CHANGE State state CHAR(2)");
		DB::update("ALTER TABLE cust_det CHANGE Pincode pincode INT(6)");
		DB::update("ALTER TABLE cust_det CHANGE Phone phone BIGINT(20)");
		DB::update("ALTER TABLE cust_det CHANGE DOB dob DATE");
		DB::update("ALTER TABLE cust_det CHANGE Gender gender CHAR(1)");
		DB::update("ALTER TABLE cust_det CHANGE iAccount_No iaccount_no INT(11)");

		Schema::table('cust_det', function($table) {
			$table->boolean('active');
			$table->datetime('created_at');
			$table->datetime('updated_at');
			$table->string('crf_no',12);
		});

		var_dump("cust_det migration done!!!!!!!!!");


		var_dump("running adjustments migration ................");

		Schema::table('adjustments', function($table) {
			$table->boolean('is_active')->default(0);
			$table->date('date');
		});	

		var_dump("adjustments migration done!!!!!!!!!");


		var_dump("running bill_det migration............");

		DB::update("ALTER TABLE bill_det CHANGE Bill_No bill_no INT(11) NOT NULL AUTO_INCREMENT");
		DB::update("ALTER TABLE bill_det CHANGE Account_ID account_id VARCHAR(12)");
		DB::update("ALTER TABLE bill_det CHANGE Cust_Current_Plan cust_current_plan VARCHAR(255)");
		DB::update("ALTER TABLE bill_det CHANGE Bill_date bill_date DATE");
		DB::update("ALTER TABLE bill_det CHANGE Bill_Start_Date bill_start_date DATE");
		DB::update("ALTER TABLE bill_det CHANGE Bill_End_Date bill_end_date DATE");
		DB::update("ALTER TABLE bill_det CHANGE Security_Deposit security_deposit DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Prev_Bal prev_bal DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Last_payment last_payment DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Adjustments adjustments DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Due_Date due_date DATE");
		DB::update("ALTER TABLE bill_det CHANGE Current_rental current_rental DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Device_Cost device_cost DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE OneTime_Charges onetime_charges DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Discount discount DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Other_Charges other_charges DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Sub_Total sub_total DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Service_tax service_tax DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Total_Charges total_charges DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Amount_Before_Due_Date amount_before_due_date DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE Amount_After_Due_Date amount_after_due_date DECIMAL(7,2)");
		DB::update("ALTER TABLE bill_det CHANGE For_Month for_month VARCHAR(10)");


		Schema::table('bill_det', function($table) {
			$table->boolean('is_active')->default(0);
			$table->boolean('active')->default(0);
		});	
		var_dump("bill_det migrations done!!!!");

		var_dump("running cheque_transactions migration ................");

		Schema::table('cheque_transactions', function($table) {
			$table->boolean('is_active')->default(0);
			$table->string('cheque_holder_name',40);
			$table->string('cheque_account_no',40);
			$table->string('ifsc_code',15);
			$table->string('cheque_status',20);
			$table->string('transaction_details');
			$table->string('status_updated_by',20);
			
		});	

		var_dump("bill_det migrations done!!!!");

		var_dump("running payment_transactions migration ................");

		Schema::table('payment_transactions', function($table) {
			$table->boolean('is_active')->default(0);
			$table->string('owner_type');
			$table->integer('owner_id');
		});	

		var_dump("payment_transactions migrations done!!!!");

		var_dump("running plan_cost_det migration ................");

		DB::update("ALTER TABLE plan_cost_det CHANGE Plan_Code plan_code INT(4)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Plan_Cost plan_cost DECIMAL(7,2)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Device_Cost device_cost DECIMAL(7,2)");
		DB::update("ALTER TABLE plan_cost_det CHANGE OneTime_Charges onetime_charges DECIMAL(7,2)");
		DB::update("ALTER TABLE plan_cost_det CHANGE iPlan_Code iplan_code INT(11)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Plan_Desc plan_desc VARCHAR(100)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Plan_Group plan_group VARCHAR(100)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Monthly_Rental monthly_rental DECIMAL(7,2)");
		DB::update("ALTER TABLE plan_cost_det CHANGE Subs subs VARCHAR(20)");

		var_dump("plan_cost_det migrations done!!!!");

		var_dump("running plan_det migration ................");

		DB::update("ALTER TABLE plan_det ADD id INT PRIMARY KEY AUTO_INCREMENT");
		DB::update("ALTER TABLE plan_det CHANGE Account_ID account_id VARCHAR(12)");
		DB::update("ALTER TABLE plan_det CHANGE Plan plan VARCHAR(40)");
		DB::update("ALTER TABLE plan_det CHANGE Plan_Code plan_code VARCHAR(4)");
		DB::update("ALTER TABLE plan_det CHANGE Plan_Start_Date plan_start_date DATE");
		DB::update("ALTER TABLE plan_det CHANGE Plan_End_Date plan_end_date DATE");

		Schema::table('plan_det', function($table) {
			$table->boolean('is_active');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		var_dump("plan_det migrations done!!!!");		

		var_dump("running roles migration ................");

		Schema::table('roles', function($table) {
			$table->text('description');
			$table->boolean('is_active');
		});

		var_dump("roles migrations done!!!!");		

		var_dump("running status migration ................");

		Schema::table('status', function($table) {
			$table->text('message');
		});

		var_dump("status migration done!!!!!!!");

		var_dump("running subs_det migration ................");

		DB::update("ALTER TABLE subs_det CHANGE Unique_Subs_No unique_subs_no INT(11) NOT NULL AUTO_INCREMENT");
		DB::update("ALTER TABLE subs_det CHANGE Account_Name account_name VARCHAR(40)");
		DB::update("ALTER TABLE subs_det CHANGE Account_ID account_id VARCHAR(30)");
		DB::update("ALTER TABLE subs_det CHANGE Account_No account_no INT(11)");
		DB::update("ALTER TABLE subs_det CHANGE Phone phone BIGINT(20)");
		DB::update("ALTER TABLE subs_det CHANGE Account_Address account_address TEXT");
		DB::update("ALTER TABLE subs_det CHANGE Domain domain VARCHAR(20)");
		DB::update("ALTER TABLE subs_det CHANGE Rate_Plan rate_plan VARCHAR(30)");
		DB::update("ALTER TABLE subs_det CHANGE Rate_Plan_Type rate_plan_type VARCHAR(15)");
		DB::update("ALTER TABLE subs_det CHANGE Activation activation DATETIME");
		DB::update("ALTER TABLE subs_det CHANGE Recharge recharge VARCHAR(40)");
		DB::update("ALTER TABLE subs_det CHANGE Expiry_Date expiry_date DATETIME");
		DB::update("ALTER TABLE subs_det CHANGE Balances balances VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Money_Bal money_bal VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Subs_Status subs_status VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Account_External_ID account_external_id VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Proof_Of_Delivery proof_of_delivery VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Device device VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Port_No port_no VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Last_Mile_No last_mile_no VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Connectivity_Through_List connectivity_through_list VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Primary_POD_Code primary_pod_code VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Secondary_POD_Code secondary_pod_code VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE RAD_Dept_Code rad_dept_code VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Customer_Type customer_type VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE FUP_Balance_Upload fup_balance_upload VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE FUP_Balance_Download fup_balance_download VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE FUP_Balance_TOTAL fup_balance_total VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Next_Change_Date next_change_date VARCHAR(50)");
		DB::update("ALTER TABLE subs_det CHANGE Next_Rate_Plan next_rate_plan VARCHAR(50)");

		Schema::table('subs_det', function($table) {
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		var_dump("subs_det migration done!!!!!!!");

		var_dump("running temp_act_det migration ................");

		DB::update("ALTER TABLE temp_act_det CHANGE Passwd password VARCHAR(13)");

		Schema::table('temp_act_det', function($table) {
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		var_dump("temp_act_det migration done!!");

		var_dump("running tickets migration ................");

		Schema::table('tickets', function($table) {
			$table->integer('status_id');
			$table->integer('belonging_id');
			$table->string('belonging_type');
			$table->boolean('is_active');
			$table->integer('owner_id');
			$table->string('owner_type');
			$table->string('crf_no');
		});

		var_dump("tickets migration done!!");

		var_dump("running usage_det migration ................");

		Schema::table('usage_det', function($table) {
			$table->increments('id');
			$table->boolean('is_active');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		var_dump("usage_det migration done!!");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
