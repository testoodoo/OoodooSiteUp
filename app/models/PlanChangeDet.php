<?php

class PlanChangeDet extends Eloquent {

	protected $table = 'planchange_details';

	static public function PlanDet($account_id){
			$plan = Plan::where('account_id','=',$account_id)->get()->first();
			$bill= Bill::orderBy('bill_no','desc')->where('account_id','=',$account_id)->get()->first();
			$plan_start_date = $bill->bill_start_date;
			$plan_end_date = $bill->bill_end_date;
			$plan_code = $plan->plan_code;

			$date_diff =strtotime($plan_end_date)-strtotime($plan_start_date);
            $used_days = $date_diff/(60 * 60 * 24)+1;
			$today_date = date("Y-m-d");
			$date_diff =strtotime($plan_end_date)-strtotime($today_date);
            $new_plan_days = $date_diff/(60 * 60 * 24)+1;

            return array("used_days"=>$used_days,"new_plan_days"=>$new_plan_days,"plan_code"=>$plan_code,
            			"plan_start_date"=>$plan_start_date,"plan_end_date"=>$plan_end_date);		
	}

	static public function PlanCostDet($used_days,$plan_code,$num_of_days){
			$plan_cost_det = PlanCostDetail::where('plan_code','=',$plan_code)->get()->first();
			$plan_cost = $plan_cost_det->plan_cost;
			$plan_data = $plan_cost_det->data_gb;
			$monthly_rental=round($plan_cost*1.1400);
			$one_day_data =number_format((float)$plan_data /$num_of_days,2);
			$normal_usage = $used_days * $one_day_data ; 
			$month_sub = $plan_cost_det->subs;
			return array("plan_cost"=>$plan_cost,"plan_data"=>$plan_data,"normal_usage"=>$normal_usage,
						"monthly_rental"=>$monthly_rental,"month_sub"=>$month_sub);			
	}

	static public function BillBalance($account_id){
			$amount_before_date = Bill::orderBy('bill_no','desc')->where('account_id','=',$account_id)->get()->first();
			if(count($amount_before_date)!=0)
			{
			     $amount_before_due_date=$amount_before_date->amount_before_due_date;
			     $amount_paid = Bill::orderBy('bill_no','desc')->where('account_id','=',$account_id)->get()->first()->amount_paid;
			     $bal=$amount_paid - $amount_before_due_date;
			     if($amount_paid==0){
			     	$bal=0;
			     }
				return $bal;
		    }else{
			     return 0;
		    }
			
	}

	static public function DataUsage($account_id){
			$usage = Jsubs::where('account_id','=',$account_id)->get()->first();
			if(count($usage)!=0){
				$plan=$usage->plan;
				$total_usage =PlanChangeDetail::data_usage_in_gb($usage->bytes_total);
				return array("plan"=>$plan,"usage"=>$usage,"total_usage"=>$total_usage);
		    }else{
		    	$plan= 0;
		    	$total_usage = 0;
				return array("plan"=>$plan,"usage"=>$usage,"total_usage"=>$total_usage);
		    }

			
	}

	static public function	ProrataDiscount($account_id,$month_sub,$plan_data,$new_plan_cost,$rem_day,$num_of_days,$prorata_bal){
			
			$plan_det = Plan::where('account_id','=',$account_id)->get()->first();
			$old_plan_code = $plan_det->plan_code;
			$old_plan_amount = PlanCostDetail::where('plan_code','=',$old_plan_code)->get()->first()->plan_cost;
			$old_plan_cost =  round($old_plan_amount + ($old_plan_amount * 0.1400));
			$prorata_dis = $old_plan_cost - $prorata_bal;

			if($month_sub == 'Monthly'){
				if($plan_data != 0){
					$prorata_cost = $new_plan_cost;
					$prorata_dis = $prorata_dis;
					$plan_amount = $new_plan_cost - $prorata_dis;
					return array("plan_amount"=>$plan_amount,"prorata_dis"=>$prorata_dis,"prorata_cost"=>$prorata_cost);
				}else{
					$plan_amount = round($rem_day * ($new_plan_cost/$num_of_days))- $prorata_dis;
					//var_dump($plan_cost_tax); die;
					$prorata_cost = $plan_amount;
					$prorata_dis = $new_plan_cost - $prorata_cost;
					return array("plan_amount"=>$plan_amount,"prorata_dis"=>$prorata_dis,"prorata_cost"=>$prorata_cost);
				}
			}else{
				$plan_amount = $new_plan_cost;
				$prorata_cost = $new_plan_cost;
				$prorata_dis = 0;
				return array("plan_amount"=>$plan_amount,"prorata_dis"=>$prorata_dis,"prorata_cost"=>$prorata_cost);
			}
		}

	static public function ProrataBalance($plan_data,$total_usage,$normal_usage,$plan_cost,$num_of_days,$used_days,$monthly_rental){
			if($plan_data != 0)
				{
				if($total_usage < $normal_usage)
					{
					$one_gb_cost = $plan_cost / $plan_data;
					$plan_usage_amount = round($total_usage * $one_gb_cost);
						if($plan_usage_amount > $plan_cost)
						{
							$prorata_balance = round($plan_cost*1.1400);
						}else{
							$prorata_balance = round($plan_usage_amount*1.1400);
						}
							return $prorata_balance;
					}
					else
					{
						$one_day_amount = $monthly_rental / $num_of_days;
						$prorata_balance = round($used_days * $one_day_amount);
						return $prorata_balance;
					}				
				} 
			else
			{ 
				$one_day_amount = $monthly_rental / $num_of_days;
				$prorata_balance = round($used_days * $one_day_amount);
				return $prorata_balance;

			}
	}

 
}