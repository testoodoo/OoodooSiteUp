<?php

class PlanChangeDetail extends Eloquent {

	protected $table = 'plan_change_details';

static public function data_usage_in_gb($usage_bytes_total){
		$get_GB = $usage_bytes_total /1000000000;
		$get_gb_percent = number_format((float)$get_GB, 2, '.', '');
		return $get_gb_percent;
	}

static public function OtherCharges($id,$account_id,$amount,$bill_no,$for_month,$planchange_id,$topup_id){
		$othercharges=OtherCharges::where('id',$id)->first();
		if(count($othercharges)!=0){
			$othercharges->account_id=$account_id;
			$othercharges->amount=$amount;
			$othercharges->for_month=$for_month;
			$othercharges->date= date("Y-m-d");
			$othercharges->save();
			
			return $othercharges;
		}else{
			$OtherCharges = new OtherCharges();
			$OtherCharges->account_id=$account_id;
			$OtherCharges->amount=$amount;
			$OtherCharges->for_month=$for_month;
			$OtherCharges->date= date("Y-m-d");
			$OtherCharges->is_considered=1;
			$OtherCharges->save();

			$bill_info_new=new Billinformation();
			$bill_info_new->bill_no=$bill_no;
			$bill_info_new->other_charges_id=$OtherCharges->id;	
			$bill_info_new->save();
			if($planchange_id){
				$plaChange=PlanChangeDetail::where('id',$planchange_id)->first();
				$plaChange->other_charges_id=$OtherCharges->id;
				$plaChange->save();
			}else{
				$topup=TopupDetail::where('id',$topup_id)->first();
				$topup->other_charges_id=$OtherCharges->id;
				$topup->save();
			}

			
			return $OtherCharges;
		}
	}

	static public function billUpdateTopup($id,$account_id,$for_month,$other_charges_new){
	    $bill=Bill::where('account_id','=',$account_id)
	               ->where('for_month',$for_month)->get()->first();

	    if(count($bill)!=0){

		$other_charges_exit=OtherCharges::where('id',$id)->first();
		$other_charges_amount=OtherCharges::where('account_id',$account_id)->where('for_month',$for_month)
												->where('id','!=',$id)->sum('amount');

		if($other_charges_exit){
	    	$amount_before_due_date= intval($bill->amount_before_due_date+$other_charges_exit->amount);
			$amount_after_due_date= intval($bill->amount_after_due_date+$other_charges_exit->amount);
			$other_charges_exit->is_considered=1;
			$other_charges_exit->remarks="topup bill no".$bill->bill_no;
			$other_charges_exit->save();
		}
			$amount_paid=$bill->amount_paid;

			if($amount_paid == 0){
            	$status = "not_paid";
            }else if ($amount_before_due_date > $amount_paid) {
                $status = "partially_paid";
        	}else if($amount_before_due_date <= $amount_paid) {
                $status = "paid"; 
       		}

        DB::table('bill_det')->where('bill_no','=',$bill->bill_no)
			->update(array(
				'other_charges' =>$other_charges_new+$other_charges_amount,
				'amount_before_due_date' => $amount_before_due_date,
				'amount_after_due_date' => $amount_after_due_date,
				'amount_paid' => $amount_paid,
				'status' => $status
			));

		return DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->first();
	    
	    }

	}

	static public function billUpdate($id,$account_id,$for_month,$other_charges_new,$plan_code,$plan_start_date){
	    $bill=Bill::where('account_id','=',$account_id)
	               ->where('for_month',$for_month)->get()->first();
	              // var_dump($bill,$for_month,$account_id);die;
	    if(count($bill)!=0){
	    
    	$plan = Plan::where('account_id','=',$account_id)->get()->first();
		$plan_cost_det = PlanCostDetail::where('plan_code','=',$plan_code)->get()->first();

		$planChange=PlanChangeDet::where('account_id',$account_id)->where('status','payment pending')->first();
		if(count($planChange)!=0){
			$planChange->plan_code=$plan_code;
			$planChange->plan_name=$plan_cost_det->plan_desc;
			$planChange->plan_change_date=$plan_start_date;
			$planChange->request_id ="44444";
			$planChange->save();
		}else{
			$planchange=new PlanChangeDet();
			$planchange->account_id=$account_id;
			$planchange->plan_code=$plan_code;
			$planchange->plan_name=$plan_cost_det->plan_desc;
			$planchange->plan_change_date=$plan_start_date;
			$planchange->request_id ="44444";
			$planchange->remarks =$bill->bill_no;
			$planchange->status="payment pending";
			$planchange->save();
		}
        
    	$account_id = $account_id;
		$for_month=$for_month;
		
		$other_charges_exit=OtherCharges::where('account_id','=',$account_id)
	               ->where('for_month',$for_month)->where('id','!=',$id)->sum('amount');
		
		$other_charges_update=OtherCharges::where('id',$id)->first();
			if(count($other_charges_update)!=0){
				
				$sub_total=$bill->sub_total;
				$service_tax=$bill->service_tax;
				$total_charges=$sub_total+$service_tax;

		    	$amount_before_due_date = intval($bill->amount_before_due_date + $other_charges_update->amount);
				$amount_after_due_date = intval($bill->amount_before_due_date + $other_charges_update->amount);
				$other_charges_update->is_considered=1;
				$other_charges_update->remarks="planchange bill no ".$bill->bill_no;
				$other_charges_update->save();

				$other_charges=$other_charges_update->amount;
				$amount_paid=$bill->amount_paid;
					
			}


            if($amount_paid == 0){
            	$status = "not_paid";
            }else if ($amount_before_due_date > $amount_paid) {
                $status = "partially_paid";
        	}else if($amount_before_due_date <= $amount_paid) {
                $status = "paid"; 
       		}



        DB::table('bill_det')->where('bill_no','=',$bill->bill_no)
			->update(array(
				'other_charges' =>$other_charges+$other_charges_exit,
				'amount_before_due_date' => $amount_before_due_date,
				'amount_after_due_date' => $amount_after_due_date,
				'amount_paid' => $amount_paid,
				'status' => $status
			));
	    return DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->first();
	    }


	}


	static public function billChange($bill_no,$new_plan_code,$trans){
		
		
		$bill=Bill::where('bill_no',$bill_no)->first();

		if(count($bill)!=0){
			$plan_cost_det = PlanCostDetail::where('plan_code','=',$new_plan_code)->get()->first();

	    	$account_id = $bill->account_id;

	    	if($trans){
	    		$cust_current_plan=$bill->cust_current_plan;
				$current_rental=$trans;
	    	}else{
				$cust_current_plan=$plan_cost_det->plan;
				$current_rental=$plan_cost_det->monthly_rental;
	    	}

			$bill_date=$bill->bill_date;
			$bill_start_date=$bill->bill_start_date;
			$bill_end_date=$bill->bill_end_date;
			$due_date=$bill->due_date;

			$for_month=$bill->for_month;
			
			$bill_last=Bill::where('account_id','=',$account_id)
	              				 ->where('bill_no','<',$bill_no)->orderBy('bill_no','desc')->first();

	        if($bill_last){
				$prev_bal=$bill_last->amount_before_due_date;
				$last_payment=$bill_last->amount_paid;
	        }else{
	        	$prev_bal=0;
				$last_payment=0;
	        }
	        
			$security_deposit=$bill->security_deposit;
			if(0<$bill->adjustments){
				$adjustments=PlanChangeDetail::billadjustment($account_id,$for_month,$bill->adjustments,$bill);	
				if($adjustments==false){
					$value=array('status' =>'false' ,'name'=>"adjustment");
					return $value;
				}
			}else{
				$adjustments=$bill->adjustments;
			}

			if($trans){
				if(0<$bill->device_cost){
					$device_cost=PlanChangeDetail::billdevicecost($account_id,$for_month,$bill->device_cost,$bill);
					if($device_cost==false){
						$value=array('status' =>'false' ,'name'=>"devicecost");
						return $value;
					}
				}else{
					$device_cost=$bill->device_cost;
				}
				
				if(0<$bill->discount){
					$discount=PlanChangeDetail::billdiscount($account_id,$for_month,$bill->discount,$bill);
					if($discount==false){
						$value=array('status' =>'false' ,'name'=>"discount");
						return $value;
					}
				}else{
					$discount=$bill->discount;
				}
				
				if(0<$bill->other_charges){
					$othercharges=PlanChangeDetail::billothercharges($account_id,$for_month,$bill->other_charges,$bill);
					if($othercharges==false){
						$value=array('status' =>'false' ,'name'=>"othercharges");
						return $value;
					}
				}else{
					$othercharges=$bill->other_charges;
				}
			}else{
				$device_cost=$bill->device_cost;
				$discount=$bill->discount;
				$othercharges=$bill->other_charges;
				$adjustments=$bill->adjustments;
			}
				
				$onetime_charges=$bill->onetime_charges;
				
				if($bill->onetime_charges){
					$sub_total=$current_rental+$othercharges+$device_cost-$discount+$onetime_charges;
				}else{
					$sub_total=$current_rental+$othercharges+$device_cost-$discount;
				}

			$service_tax=ceil($sub_total*0.1400);
			$total_charges=$sub_total+$service_tax;
	    	$amount_before_due_date = intval(($prev_bal -$last_payment) + ($total_charges-$adjustments));
			$amount_after_due_date = intval(($prev_bal - $last_payment) + ($total_charges-$adjustments));

			$amount_paid=PaymentTransaction::where('bill_no',$bill->bill_no)->where('status','success')->sum('amount');


	            if($amount_before_due_date <= $amount_paid) {
	                $status = "paid";
	            }else if($amount_paid == 0){
	            	$status = "not_paid";
	        	}else if ($amount_before_due_date > $amount_paid) {
	                $status = "partially_paid";
	       		}



	        DB::table('bill_det')->where('bill_no','=',$bill->bill_no)
				->update(array(
					'account_id'=>$account_id,
					'cust_current_plan'=>$cust_current_plan,
					'bill_date'=>$bill_date,
					'bill_start_date'=>$bill_start_date,
					'bill_end_date'=>$bill_end_date,
					'due_date'=>$due_date,
					'security_deposit'=>$security_deposit,
					'prev_bal'=>$prev_bal,
					'last_payment'=>$last_payment,
					'current_rental'=>$current_rental,
					'onetime_charges'=>$onetime_charges,
					'sub_total'=>$sub_total,
					'service_tax'=>$service_tax,
					'total_charges'=>$total_charges,
					'for_month'=>$for_month,
					'device_cost' =>$device_cost,
					'adjustments' =>$adjustments,
					'discount' =>$discount,
					'other_charges' =>$othercharges,
					'amount_before_due_date' => $amount_before_due_date,
					'amount_after_due_date' => $amount_after_due_date,
					'amount_paid' => $amount_paid,
					'status' => $status
				));

			return DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->first();
		}

	}

	static public function billadjustment($account_id,$for_month,$amount,$bill){
		$bill_info=Billinformation::where('bill_no',$bill->bill_no)->get();
		foreach ($bill_info as $key) {
			$amount_id[]=$key->adjustment_id;
		}
		if(count($bill_info)==0){
			$amount_id[]=NULL;
		}
		$bill_amount=Adjustment::whereIn('id',$amount_id)->sum('amount');
		if($bill->adjustments == $bill_amount){
			return $bill_amount;
		
		}else if($bill->adjustments && $bill_amount == 0){
			$adjustment = new Adjustment();
			$adjustment->account_id =$account_id;
			$adjustment->for_month =$for_month;
	        $adjustment->amount = $amount;
	        $adjustment->date =date('Y-m-d');
			$adjustment->remarks = "billadjustment retransaction";
			$adjustment->is_considered =1;		
			$adjustment->save();
			$bill_info=Adjustment::adjustments($adjustment->id,$adjustment->account_id,$adjustment->for_month);
			return $adjustment->amount;
		}else if($bill->adjustments != $bill_amount){
				return false;
		}
	}

	static public function billdevicecost($account_id,$for_month,$amount,$bill){
		$bill_info=Billinformation::where('bill_no',$bill->bill_no)->get();
		foreach ($bill_info as $key) {
			$amount_id[]=$key->device_cost_id;
		}
		if(count($bill_info)==0){
			$amount_id[]=NULL;
		}
		$bill_amount=DeviceCost::whereIn('id',$amount_id)->sum('amount');
		if($bill->device_cost == $bill_amount){
			return $bill_amount;
		
		}else if($bill->device_cost && $bill_amount == 0){
			$devicecost = new DeviceCost();
			$devicecost->account_id =$account_id;
			$devicecost->for_month =$for_month;
	        $devicecost->amount = $amount;
	        $devicecost->date =date('Y-m-d');
			$devicecost->remarks = "billdevicecost retransaction";
			$devicecost->is_considered =1;		
			$devicecost->save();
			$bill_info=Discount::devicecost($devicecost->id,$devicecost->account_id,$devicecost->for_month);
			return $devicecost->amount;
		}else if($bill->device_cost != $bill_amount){
				return false;
		}
	}

	static public function billdiscount($account_id,$for_month,$amount,$bill){
		$bill_info=Billinformation::where('bill_no',$bill->bill_no)->get();
		foreach ($bill_info as $key) {
			$amount_id[]=$key->discount_id;
		}
		if(count($bill_info)==0){
			$amount_id[]=NULL;
		}
		$bill_amount=Discount::whereIn('id',$amount_id)->sum('amount');
		if($bill->discount == $bill_amount){
			return $bill_amount;
		
		}else if($bill->discount && $bill_amount == 0){
			$discount = new Discount();
			$discount->account_id =$account_id;
			$discount->for_month =$for_month;
	        $discount->amount = $amount;
	        $discount->date =date('Y-m-d');
			$discount->remarks = "billdiscount retransaction";
			$discount->is_considered =1;		
			$discount->save();
			$bill_info=Discount::discounts($discount->id,$discount->account_id,$discount->for_month);
			return $discount->amount;
		}else if($bill->discount != $bill_amount){
				return false;
		}
	}

	static public function billothercharges($account_id,$for_month,$amount,$bill){
		$bill_info=Billinformation::where('bill_no',$bill->bill_no)->get();
		foreach ($bill_info as $key) {
			$amount_id[]=$key->other_charges_id;
		}
		if(count($bill_info)==0){
			$amount_id[]=NULL;
		}
		$bill_amount=OtherCharges::whereIn('id',$amount_id)->sum('amount');
		if($bill->other_charges == $bill_amount){
			return $bill_amount;
		
		}else if($bill->other_charges && $bill_amount == 0){
			$othercharges = new OtherCharges();
			$othercharges->account_id =$account_id;
			$othercharges->for_month =$for_month;
	        $othercharges->amount = $amount;
	        $othercharges->date =date('Y-m-d');
			$othercharges->remarks = "billothercharges retransaction";
			$othercharges->is_considered =1;		
			$othercharges->save();
			$bill_info=Discount::othercharges($othercharges->id,$othercharges->account_id,$othercharges->for_month);
			return $othercharges->amount;
		}else if($bill->other_charges != $bill_amount){
				return false;
		}
	}

}