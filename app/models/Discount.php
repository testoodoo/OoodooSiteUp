<?php

class Discount extends Eloquent {

	protected $table = 'discounts';

	//discount update
	static public function discounts($id,$account_id,$for_month){

	  $bill_no=Bill::where('account_id','=',$account_id)
	               ->where('for_month','=',$for_month)->get()->first();
	if(!is_null($bill_no))
	  	 {
	       $bill_info=new Billinformation();
	       $bill_info->discount_id=$id;
	       $bill_info->bill_no=$bill_no->bill_no;
	       $bill_info->save();
		}
	}
	static public function discountsUpdate($discount_id){
	    $bill_info=Billinformation::where('discount_id','=',$discount_id)->get()->first();
	       $bill_info->discount_id=$discount_id;
	       $bill_info->save();
	}
	//device cost update
	static public function devicecost($id,$account_id,$for_month){

	  $bill_no=Bill::where('account_id','=',$account_id)
	               ->where('for_month','=',$for_month)->get()->first();
	   if(!is_null($bill_no))
	  	 {
		 
	       $bill_info=new Billinformation();
	       $bill_info->device_cost_id=$id;
	       $bill_info->bill_no=$bill_no->bill_no;
	       $bill_info->save();
		}

	}

	static public function devicecostUpdate($id){
	    $bill_info=Billinformation::where('device_cost_id','=',$id)->get()->first();
	       $bill_info->device_cost_id=$id;
	       $bill_info->save();
	}
	//othercharges update
	static public function othercharges($id,$account_id,$for_month){

	  $bill_no=Bill::where('account_id','=',$account_id)
	               ->where('for_month','=',$for_month)->get()->first();
	   if(!is_null($bill_no))
	  	 {
			  $bill_exit=Billinformation::where('bill_no','=',$bill_no->bill_no)->get()->first();
		       $bill_info=new Billinformation();
		       $bill_info->other_charges_id=$id;
		       $bill_info->bill_no=$bill_no->bill_no;
		       $bill_info->save();
		}
	}
	static public function otherchargesUpdate($id){
	    $bill_info=Billinformation::where('other_charges_id','=',$id)->get()->first();
	       $bill_info->other_charges_id=$id;
	       $bill_info->save();
	}
}