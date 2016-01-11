<?php

class TopupCostSeeder extends Seeder {

	public function run() {


		//////////////////////////////////////////////////////////////////////////////////
		// new row should be added at the bottom. do no insert in between ///////////
		///////////////////////////////////////////////////////////////////////////////

		DB::table('topup_cost_details')->truncate();
		
        TopupCostDetail::create(array('speed' =>8, 'data' =>5,'cost' =>75));
        TopupCostDetail::create(array('speed' =>8, 'data' =>25,'cost' =>300));
        TopupCostDetail::create(array('speed' =>8, 'data' =>50,'cost' =>500));
        TopupCostDetail::create(array('speed' =>8, 'data' =>100,'cost' =>800));
        
        TopupCostDetail::create(array('speed' =>10, 'data' =>5,'cost' =>55));
        TopupCostDetail::create(array('speed' =>10, 'data' =>25,'cost' =>275));
        TopupCostDetail::create(array('speed' =>10, 'data' =>50,'cost' =>550));
        TopupCostDetail::create(array('speed' =>10, 'data' =>100,'cost' =>1000));

        TopupCostDetail::create(array('speed' =>25, 'data' =>5,'cost' =>100));
        TopupCostDetail::create(array('speed' =>25, 'data' =>25,'cost' =>350));
        TopupCostDetail::create(array('speed' =>25, 'data' =>50,'cost' =>600));
        TopupCostDetail::create(array('speed' =>25, 'data' =>100,'cost' =>1000));

        TopupCostDetail::create(array('speed' =>30, 'data' =>5,'cost' =>100));
        TopupCostDetail::create(array('speed' =>30, 'data' =>25,'cost' =>400));
        TopupCostDetail::create(array('speed' =>30, 'data' =>50,'cost' =>650));
        TopupCostDetail::create(array('speed' =>30, 'data' =>100,'cost' =>1000));

        TopupCostDetail::create(array('speed' =>50, 'data' =>5,'cost' =>100));
        TopupCostDetail::create(array('speed' =>50, 'data' =>25,'cost' =>400));
        TopupCostDetail::create(array('speed' =>50, 'data' =>50,'cost' =>700));
        TopupCostDetail::create(array('speed' =>50, 'data' =>100,'cost' =>1000));

        TopupCostDetail::create(array('speed' =>75, 'data' =>5,'cost' =>100));
        TopupCostDetail::create(array('speed' =>75, 'data' =>25,'cost' =>350));
        TopupCostDetail::create(array('speed' =>75, 'data' =>50,'cost' =>600));
        TopupCostDetail::create(array('speed' =>75, 'data' =>100,'cost' =>1000));

        
		
	}
}