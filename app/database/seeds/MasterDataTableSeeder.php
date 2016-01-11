<?php

class MasterDataTableSeeder extends Seeder {

	public function run() {


		//////////////////////////////////////////////////////////////////////////////////
		// new row should be added at the bottom. do no insert in between ///////////
		///////////////////////////////////////////////////////////////////////////////

		DB::table('master_data')->truncate();
		
        Masterdata::create(array('name' => 'New Connection', 'type' => 'ticket_type','active' => 1));
        Masterdata::create(array('name' => 'Complaint', 'type' => 'ticket_type','active' => 1));

		Masterdata::create(array('name' => 'Open', 'type' => 'ticket_status','active' => 1));
		Masterdata::create(array('name' => 'Closed', 'type' => 'ticket_status','active' => 1));
		Masterdata::create(array('name' => 'Processing', 'type' => 'ticket_status','active' => 1));
		Masterdata::create(array('name' => 'Invalid', 'type' => 'ticket_status','active' => 1));
		Masterdata::create(array('name' => 'Trash', 'type' => 'ticket_status','active' => 1));

		Masterdata::create(array('name' => 'Urgent', 'type' => 'ticket_priority','active' => 1));
		Masterdata::create(array('name' => 'High', 'type' => 'ticket_priority','active' => 1));
		Masterdata::create(array('name' => 'Medium', 'type' => 'ticket_priority','active' => 1));
		Masterdata::create(array('name' => 'Low', 'type' => 'ticket_priority','active' => 1));

		Masterdata::create(array('name' => 'Chennai', 'type' => 'city','active' => 1));
		
		Masterdata::create(array('name' => 'OFAPL', 'type' => 'document_type', 'active' => 1));
		Masterdata::create(array('name' => 'OFPHO', 'type' => 'document_type', 'active' => 1));
		Masterdata::create(array('name' => 'OFPOI', 'type' => 'document_type', 'active' => 1));
		Masterdata::create(array('name' => 'OFPOA', 'type' => 'document_type', 'active' => 1));;

		Masterdata::create(array('name' => 'fiber', 'type' => 'customer_activation_process','active' => 1));
        Masterdata::create(array('name' => 'splicing', 'type' => 'customer_activation_process','active' => 1));
        Masterdata::create(array('name' => 'ethernet', 'type' => 'customer_activation_process','active' => 1));
        Masterdata::create(array('name' => 'HUT boxes', 'type' => 'customer_activation_process','active' => 1));
        Masterdata::create(array('name' => 'configuration', 'type' => 'customer_activation_process','active' => 1));

		Masterdata::create(array('name' => 'Sholinganaloor', 'type' => 'area','active' => 1));
		Masterdata::create(array('name' => 'Karapakam', 'type' => 'area','active' => 1));
		Masterdata::create(array('name' => 'Navallur', 'type' => 'area','active' => 1));
		Masterdata::create(array('name' => 'Kumaran nager', 'type' => 'area','active' => 1));
		Masterdata::create(array('name' => 'Chemencherry', 'type' => 'area','active' => 1));
		
		Masterdata::create(array('name' => 'NewConnections Pre Request', 'type' => 'ticket_type','active' => 1));
		Masterdata::create(array('name' => 'Technical Complaint', 'type' => 'Complaint','active' => 1));
		Masterdata::create(array('name' => 'Billing Complaint', 'type' => 'Complaint','active' => 1));
		
	}
}