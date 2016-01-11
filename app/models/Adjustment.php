<?php
class Adjustment extends \LaravelBook\Ardent\Ardent {

	protected $table = 'adjustments';

	static public function adjustments($id,$account_id,$for_month){

	  $bill_no=Bill::where('account_id','=',$account_id)
	               ->where('for_month','=',$for_month)->get()->first();
	 if(!is_null($bill_no))
	  	 {	
	       $bill_info=new Billinformation();
	       $bill_info->adjustment_id=$id;
	       $bill_info->bill_no=$bill_no->bill_no;
	       $bill_info->save();
		}

	}
	static public function adjustmentUpdate($id){
	    $bill_info=Billinformation::where('adjustment_id','=',$id)->get()->first();
        $bill_info->adjustment_id=$id;
        $bill_info->save();
	}

	static public function formonth($plan_start_date){
	$plan_start_day = date("d",strtotime($plan_start_date));
	$bill=Bill::where('account_id',Input::get('account_id'))->orderBy('bill_no','desc')->first();
		if(Input::get('for_month') == "current"){
			    $for_month=$bill->for_month;
		}else{
			   $for_month=date("M-y", strtotime("+1 month",strtotime($bill->for_month)));
		}
		return $for_month;
	}

	static public function billUpdate($id,$account_id,$for_month,$adjustments_new,$device_cost_new,$discount_new,$other_charges_new,$for_month_last,$update){
	    if(count($for_month_last)!=0){
	    	$bill=Bill::where('account_id','=',$account_id)
	               ->where('for_month',$for_month_last)->get()->first();
	    }else{
		    $bill=Bill::where('account_id','=',$account_id)
		               ->where('for_month',$for_month)->get()->first();
	    }
	              // var_dump($bill,$for_month,$account_id);die;
	    if(count($bill)!=0){

	    $bill_now=Bill::where('account_id','=',$account_id)->where('for_month',$for_month)->first();

		if($for_month_last){
			$previous_balance=ceil($bill->amount_before_due_date);
			$last_payment=ceil($bill->amount_paid);
		}else{
			$previous_balance=ceil($bill->prev_bal);
			$last_payment=ceil($bill->last_payment);
		}
		
		$amount_paid=PaymentTransaction::where('bill_no',$bill_now->bill_no)->where('account_id',$account_id)->where('status','success')->sum('amount');

		$account_id=$bill->account_id;								
		$bill_date=$bill->bill_date;
		$bill_start_date=$bill->bill_start_date;
		$bill_end_date=$bill->bill_end_date;
		$due_date=$bill->due_date;
		$security_deposit=$bill->security_deposit;
		$status=$bill->status;
		
		if(count($update)!=0){
			$adjust=Adjustment::where('account_id','=',$account_id)->where('for_month',$for_month)->where('id','!=',$id)->sum('amount');
			$device=DeviceCost::where('account_id','=',$account_id)->where('for_month',$for_month)->where('id','!=',$id)->sum('amount');
			$other_c=OtherCharges::where('account_id','=',$account_id)->where('for_month',$for_month)->where('id','!=',$id)->sum('amount');
			$discount=Discount::where('account_id','=',$account_id)->where('for_month',$for_month)->where('id','!=',$id)->sum('amount');
			
			$device_cost=$device+$device_cost_new;
			$other_charges=$other_c+$other_charges_new;
			$discount=$discount+$discount_new;
			$adjustments=$adjust+$adjustments_new;

		}else{
			$device_cost=$bill->device_cost+$device_cost_new;
			$other_charges=$bill->other_charges+$other_charges_new;
			$discount=$bill->discount+$discount_new;
			$adjustments=$bill->adjustments+$adjustments_new;
		}
		
		if(count($adjustments_new)!=0){
			$adjustment_update=Adjustment::where('id',$id)->first();
			$adjustment_update->is_considered='Y';
			$adjustment_update->save();

		}
		if(count($device_cost_new)!=0){
			$device_cost_update=DeviceCost::where('id',$id)->first();
			$device_cost_update->is_considered=1;
			$device_cost_update->save();
		}
		if(count($other_charges_new)!=0){
			$other_charges_update=OtherCharges::where('id',$id)->first();
			$other_charges_update->is_considered=1;
			$other_charges_update->save();
		}

		if(count($discount_new)!=0){
			$discount_update=Discount::where('id',$id)->first();
			$discount_update->is_considered=1;
			$discount_update->save();
		}
		
	    $bill_count=Bill::where('account_id',$account_id)->get();
	    if($for_month_last){
		    if (count($bill_count)==1) {
				$current_rental=$bill->current_rental;
				$onetime_charges=$bill->onetime_charges;
				$sub_total=$current_rental;
				$service_tax=ceil($sub_total*0.14);
				$plan_name=$bill->cust_current_plan;
				$total_charges=ceil($sub_total+$service_tax);
				$total_amount=ceil($sub_total+$service_tax-$adjustments+$other_charges-$discount+$device_cost+$onetime_charges);
		    }else{
				$current_rental=$bill_now->current_rental;
				$sub_total=$current_rental;
				$onetime_charges=$bill_now->onetime_charges;
				$service_tax=ceil($sub_total*0.14);
				$plan_name=$bill_now->cust_current_plan;
				$total_charges=ceil($sub_total+$service_tax);
				$total_amount=ceil($sub_total+$service_tax-$adjustments+$other_charges-$discount+$device_cost);
		    }
        }else{

			$current_rental=$bill_now->current_rental;
			$onetime_charges=$bill_now->onetime_charges;
			$sub_total=$current_rental;
			$service_tax=ceil($sub_total*0.14);
			$total_charges=ceil($sub_total+$service_tax);
			$plan_name=$bill_now->cust_current_plan;
				if (count($bill_count)==1) {
					$total_amount=ceil($sub_total+$service_tax-$adjustments+$other_charges-$discount+$device_cost+$onetime_charges);
				}else{
					$total_amount=ceil($sub_total+$service_tax-$adjustments+$other_charges-$discount+$device_cost);
				}
        }
        
    	$amount_before_due_date = intval(($previous_balance -$last_payment) + ($total_amount));
		$amount_after_due_date = intval(($previous_balance- $last_payment) + ($total_amount));
		

		if($amount_paid == 0){
        	$status = "not_paid";
        }else if ($amount_before_due_date > $amount_paid) {
            $status = "partially_paid";
    	}else if($amount_before_due_date <= $amount_paid) {
            $status = "paid"; 
   		}

        DB::table('bill_det')->where('bill_no','=',$bill_now->bill_no)
			->update(array(
				'prev_bal'=>$previous_balance,
				'last_payment'=>$last_payment,
				'current_rental'=>$current_rental,
				'service_tax'=>$service_tax,
				'total_charges' =>$total_charges,
				'sub_total' =>$sub_total,
				'device_cost' =>$device_cost,
				'adjustments' =>$adjustments,
				'discount' =>$discount,
				'other_charges' =>$other_charges,
				'amount_before_due_date' => $amount_before_due_date,
				'amount_after_due_date' => $amount_after_due_date,
				'amount_paid' => $amount_paid,
				'status' => $status,
			));
	    }
	}


}
