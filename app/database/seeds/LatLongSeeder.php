<?php

class LatLongSeeder extends Seeder {

	public function run() {


		//////////////////////////////////////////////////////////////////////////////////
		// new row should be added at the bottom. do no insert in between ///////////
		///////////////////////////////////////////////////////////////////////////////

	DB::table('lat_long_area')->truncate();
		
        LatLongDetails::create(array('area'=>'Sholinganallur','lat'=>12.894712,'long' =>80.230402));
        LatLongDetails::create(array('area'=>'Karapakam','lat'=>12.918059,'long' =>80.229844));
        LatLongDetails::create(array('area'=>'Navallur','lat' =>12.847677,'long' =>80.224925));
        LatLongDetails::create(array('area'=>'Kumaran Nagar','lat' =>12.876499,'long' =>80.226980));
        LatLongDetails::create(array('area'=>'Chemencherry','lat' =>12.858658,'long' =>80.230488));
        LatLongDetails::create(array('area'=>'Ogiyyam Thoraipakkam','lat' =>12.945899,'long' =>80.239370));
        LatLongDetails::create(array('area'=>'Mettukuppam','lat' =>12.939925,'long' =>80.235960));
        LatLongDetails::create(array('area'=>'PTC','lat' =>12.933609,'long' =>80.232879));
        LatLongDetails::create(array('area'=>'Thoraipakkam','lat' =>12.951943,'long' =>80.241434));
        LatLongDetails::create(array('area'=>'Perungudi','lat' =>12.968241,'long' =>80.241984));
        LatLongDetails::create(array('area'=>'Neelankarai','lat' =>12.948612,'long' =>80.254546));
        LatLongDetails::create(array('area'=>'kottivakkam','lat' =>12.969478,'long' =>80.258962));
        LatLongDetails::create(array('area'=>'thiruvanmayur','lat' =>12.983187,'long' =>80.259976));
        LatLongDetails::create(array('area'=>'adayar','lat' =>13.006565,'long' =>80.257483));
        LatLongDetails::create(array('area'=>'Besant Nagar','lat' =>12.999359,'long' =>80.267980));
        LatLongDetails::create(array('area'=>'pallavakkam','lat' =>12.962583,'long' =>80.256863));
        LatLongDetails::create(array('area'=>'Medavakkam','lat' =>12.920203,'long' =>80.186015));
        LatLongDetails::create(array('area'=>'Perumbakkam','lat' =>12.898582,'long' =>80.199358));

        Masterdata::create(array('name' => 'Incident', 'type' => 'Complaint','active' => 1));
        
		
	}
}