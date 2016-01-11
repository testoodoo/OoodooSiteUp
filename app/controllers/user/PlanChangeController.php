<?php
namespace User;
use Auth, Plan, PlanCostDetail, ConstantValue, DataUsage, Redirect, Response, View, PlanChangeDetail, BaseController, Bill, Input,PlanChangeDet;
class PlanChangeController extends BaseController {

	public function plan_change(){
			// current plan details
			$account_id = Auth::user()->get()->account_id;

			$plan_det=PlanChangeDet::PlanDet($account_id);

			$num_of_days=date("t");

			$plan_costDet=PlanChangeDet::PlanCostDet($plan_det["used_days"],$plan_det["plan_code"],$num_of_days);
			
			$data['plan']=Plan::where('account_id','=',$account_id)->get()->first();

			$usage=PlanChangeDet::DataUsage($account_id);
			$data['usage']=$usage;
			
			$data['prorata_bal']=PlanChangeDet::prorataBalance($plan_costDet["plan_data"],$usage["total_usage"],$plan_costDet["normal_usage"],
											$plan_costDet["plan_cost"],$num_of_days,$plan_det["used_days"],$plan_costDet["monthly_rental"]);

			$data['bill_bal']=PlanChangeDet::BillBalance($account_id);
			
        	$data['used_day'] = $plan_det["used_days"];
			
			$data['current_plan'] = PlanCostDetail::where('plan_code','=',$plan_det["plan_code"])->get()->first()->plan_desc;
			$data['old_plan_code'] = $plan_det["plan_code"];

			$data['normal_plan']= PlanCostDetail::distinct()->where('plan_group','=','normal')
															->get(array('subs'));


			return View::make('user.planchange.plan_change',$data);
	 }

	public function month_sub(){

		//Select plan drop down
		$month_sub = Input::get('month_sub');
		$plan_list = PlanCostDetail::where('subs','=',$month_sub)
									->where('plan_group','=','Normal')
									->whereNotBetween('plan_code',['1459','1460'])->get();

		foreach($plan_list as $row){

			$plan_code = $row['plan_code'];
			$plan = $row['plan_desc'];
			$subs[$plan_code] = $plan;
		}
		$subs['0'] = 'Select Plan';
		echo json_encode($subs);

	}

	public function fetch_plan_det(){
			//same as plan change()
			$plan_code = Input::get('plan_code');
			$account_id = Auth::user()->get()->account_id;
			$prorata_bal = Input::get('prorata_bal');
			$plan_start = Input::get('plan_start');

			$plan= Plan::where('account_id','=',$account_id)->where('plan_start_date','<=',$plan_start)
															->where('plan_end_date','>=',$plan_start)->get()->first();
			
			$bill_bal=PlanChangeDet::BillBalance($account_id);

			$plan_det=PlanChangeDet::PlanDet($account_id);

			$num_of_days=date("t");

			$plan_costDet=PlanChangeDet::PlanCostDet($plan_det["used_days"],$plan_code,$num_of_days);
			
			$new_plan_cost =  round($plan_costDet["plan_cost"] + ($plan_costDet["plan_cost"] * 0.1400));
			

			$prorata=PlanChangeDet::ProrataDiscount($account_id,$plan_costDet["month_sub"],$plan_costDet["plan_data"],
									$new_plan_cost,$plan_det["new_plan_days"],$plan_det["used_days"],$prorata_bal);

			$payable_amt = $prorata["plan_amount"] - $bill_bal;


			if($payable_amt <= 0)
				{
					$payable_amt = 1;
				}


 			if(count($plan_det)!=0){
			$response = array(
						'found' => "true",
						'plan_cost_tax' => $new_plan_cost,
						'prorata_cost' => $prorata["prorata_cost"],
						'prorata_dis' => $prorata["prorata_dis"],
						'payable_amt' => $payable_amt,
					);
				return Response::json($response);
			}
			return Response::json(array('found' => "false"));

	}


	public function planchange_store(){

			$plan_code = Input::get('plan_code');
			$account_id = Auth::user()->get()->account_id;
			$prorata_bal = Input::get('prorata_bal');
			$plan_start = Input::get('plan_start_date');

			$plan= Plan::where('account_id','=',$account_id)->where('plan_start_date','<=',$plan_start)
															->where('plan_end_date','>=',$plan_start)->get()->first();

			$bill_bal=PlanChangeDet::BillBalance($account_id);

			$plan_det=PlanChangeDet::PlanDet($account_id);

			$num_of_days=date("t");

			$plan_costDet=PlanChangeDet::PlanCostDet($plan_det["used_days"],$plan_code,$num_of_days);
			
			$new_plan_cost =  round($plan_costDet["plan_cost"] + ($plan_costDet["plan_cost"] * 0.1400));
			

			$prorata=PlanChangeDet::ProrataDiscount($account_id,$plan_costDet["month_sub"],$plan_costDet["plan_data"],
									$new_plan_cost,$plan_det["new_plan_days"],$plan_det["used_days"],$prorata_bal);

			$payable_amt_val = $prorata["plan_amount"] - $bill_bal;


			if($payable_amt_val <= 0)
				{
					$payable_amt_val = 1;
				}
				
		$plan_start_date=Input::get('plan_start_date');
		$bills=Bill::where('account_id','=',Auth::user()->get()->account_id)->orderBy('bill_no','desc')->first();
		$for_month=$bills->for_month;	
		//verfication 
		if(Input::get('payable_amount') == $payable_amt_val){
		
		$bill=Bill::where('account_id','=',Auth::user()->get()->account_id)->where('for_month','=',$for_month)->get()->first();

		if(count($bill)!=0){
			
			$plaChange=PlanChangeDetail::where('bill_no',$bill->bill_no)->where('account_id',Auth::user()->get()->account_id)->first();
	    	if(count($plaChange)!=0){

		    	$plaChange->account_id =  Auth::user()->get()->account_id;
				$plaChange->bill_no =$bill->bill_no;
				$plaChange->old_plan_code = Input::get('old_plan_code');
				$plaChange->used_days = Input::get('used_day');
				$plaChange->data_usage = Input::get('total_usage');
				$old_balance =  Input::get('old_balance');
				$plaChange->old_balance = $old_balance;
				$plaChange->new_plan_code = Input::get('plan_code');
				$plaChange->plan_amount = Input::get('plan_amount');
				$prorata_dis = Input::get('prorata_bal');
				$plaChange->prorate_balance = Input::get('prorata_bal');
				$plaChange->prorate_cost = Input::get('prorata_cost');
					if($prorata_dis != NULL){
						$plaChange->prorate_discount = Input::get('prorata_dis');
					}else{
						$plaChange->prorate_discount = 0 ;	
					}
				$plaChange->payable_amount = $payable_amt_val;
				$plaChange->save();
				
				$payable_amount = Input::get('payable_amount');

				if($bill->bill_start_date == $plan_start_date){
					
					$planBill=PlanChangeDetail::billChange($bill->bill_no,$plaChange->new_plan_code,NULL);
					
					$this->PlanChange($plaChange->new_plan_code,Auth::user()->get()->account_id,$plan_start_date,$bill->bill_no);
				
				}else if($bill->bill_start_date > $plan_start_date){
					
					$OtherCharges=PlanChangeDetail::OtherCharges($plaChange->other_charges_id,Auth::user()->get()->account_id,$payable_amount,$bill->bill_no,$for_month,$plaChange->id,NULL);
					
					$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Auth::user()->get()->account_id,$for_month,$OtherCharges->amount,$plaChange->new_plan_code,$plan_start_date);
					
					$bill_new=Bill::where('account_id','=',$bill->account_id)
	              				 ->where('for_month',date('M-y',strtotime('+1 month',strtotime($bill->for_month))))->get()->first();
	              	
	              	if($bill_new){
	              		$planBill=PlanChangeDetail::billChange($bill_new->bill_no,$plaChange->new_plan_code,NULL);
	              	}
				}else if($bill->bill_start_date < $plan_start_date) {
					
					$OtherCharges=PlanChangeDetail::OtherCharges($plaChange->other_charges_id,Auth::user()->get()->account_id,$payable_amount,$bill->bill_no,$for_month,$plaChange->id,NULL);
					
					$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Auth::user()->get()->account_id,$for_month,$OtherCharges->amount,$plaChange->new_plan_code,$plan_start_date);
				}
			
			}else{
			
				$plandet = new PlanChangeDetail();
				$plandet->account_id =  Auth::user()->get()->account_id;
				$plandet->bill_no =$bill->bill_no;
				$plandet->last_amount_before_due_date =$bill->amount_before_due_date;
				$plandet->old_plan_code = Input::get('old_plan_code');
				$plandet->used_days = Input::get('used_day');
				$plandet->data_usage = Input::get('total_usage');
				$old_balance =  Input::get('old_balance');
				$plandet->old_balance = $old_balance;
				$plandet->new_plan_code = Input::get('plan_code');
				$plandet->plan_amount = Input::get('plan_amount');
				$prorata_dis = Input::get('prorata_bal');
				$plandet->prorate_balance = Input::get('prorata_bal');
				$plandet->prorate_cost = Input::get('prorata_cost');
					if($prorata_dis != NULL){
						$plandet->prorate_discount = Input::get('prorata_dis');
					}else{
						$plandet->prorate_discount = 0 ;	
					}
				$plandet->payable_amount = $payable_amt_val;
				$plandet->save();
				
				$payable_amount = Input::get('payable_amount');

				if($bill->bill_start_date == $plan_start_date){
						
						$planBill=PlanChangeDetail::billChange($bill->bill_no,$plandet->new_plan_code,NULL);
						
						$this->PlanChange($plandet->new_plan_code,Auth::user()->get()->account_id,$plan_start_date,$bill->bill_no);

				}else if($bill->bill_start_date > $plan_start_date){
					
					$OtherCharges=PlanChangeDetail::OtherCharges(NULL,Auth::user()->get()->account_id,$payable_amt_val,$bill->bill_no,$for_month,$plandet->id,NULL);
					
					$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Auth::user()->get()->account_id,$for_month,$OtherCharges->amount,$plandet->new_plan_code,$plan_start_date);
					
					$bill_new=Bill::where('account_id','=',$bill->account_id)
	              				 ->where('for_month',date('M-y',strtotime('+1 month',strtotime($bill->for_month))))->get()->first();
					
					if($bill_new){
	              		$planBill=PlanChangeDetail::billChange($bill_new->bill_no,$plandet->new_plan_code,NULL);
	              	}
				}else if($bill->bill_start_date < $plan_start_date) {
					
					$OtherCharges=PlanChangeDetail::OtherCharges(NULL,Auth::user()->get()->account_id,$payable_amt_val,$bill->bill_no,$for_month,$plandet->id,NULL);
					
					$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Auth::user()->get()->account_id,$for_month,$OtherCharges->amount,$plandet->new_plan_code,$plan_start_date);
				}

			}
			
			$amount_pay=$planBill->amount_before_due_date-$planBill->amount_paid;
			if($amount_pay <=0){
				$amount_to_pay=1;
			}else{
				$amount_to_pay=$amount_pay;
			}
			
			return Redirect::to('payment/payment_confirm')
				->with('bill_no', $bill->bill_no)
				->with('payable_amount', $amount_to_pay);
			}else{
				return Redirect::back()->with("failure","Bill yet to be not generated Plan Change is not possible");	
			}
		}else{
			return Redirect::back()->with('failure','Invalid amount, Please try again');
		}
	
	}

	public function PlanChange($plan_code,$account_id,$plan_start_date,$bill_no){

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
			$planchange->remarks =$bill_no;
			$planchange->status="payment pending";
			$planchange->save();
		}
	}

	

}