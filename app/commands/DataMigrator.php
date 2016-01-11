<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DataMigrator extends Command {

	protected $name = 'migrate:db';
	protected $description = 'Migrate Old DB to new DB';

	public function __construct()
	{
		parent::__construct();
	}

	public function fire() {
		/*$tables = DB::select('SHOW TABLES');

		foreach ($tables as $key => $table) {
			$old_table_name = $table->Tables_in_oodoo_current;

			$new_table_name = "old_" . $old_table_name;

			Schema::rename($old_table_name,$new_table_name);
		}*/


		//First Migrate Cust Det Table

		$old_cust_det = OldCustDet::all();

		foreach ($old_cust_det as $key => $value) {
			var_dump($value->Account_ID);
		}

		foreach ($old_cust_det as $ocd) {

			$cust_det = CusDet::where('account_no','=',$ocd->Account_No)->get()->first();

			//check if data already exists

			if(is_null($cust_det)){
				DB::table('cust_det')->insert(
					array('account_no' => $ocd->Account_No,
						'account_id' => $ocd->Account_ID)
				);
				var_dump("inserted");
			}

		}

		//Then Alter the columns based on Upgrade!!
		
		
	}
}
