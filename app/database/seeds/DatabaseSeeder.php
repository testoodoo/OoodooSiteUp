<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		//$this->call('EmployeeSeeder');
		//$this->call('MasterDataTableSeeder');
		//$this->call('TopupCostSeeder');
		$this->call('LatLongSeeder');

	}

}
