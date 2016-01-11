<?php

namespace Admin;
use View,Input,PlanCostDetail,Plan,DataUsage,Bill,Response,PlanChangeDetail,Jsubs,PlanChangeDet,Redirect;

class PlanchangeController extends \BaseController {

	
	public function index(){
			$data['normal_plan']= PlanCostDetail::distinct()->where('plan_group','=','normal')
									->get(array('subs'));

		return View::make('admin.planchange.index',$data);		
	}
	public function FetchAccountId(){

			$account_id = Input::get('account_id');

        	$plan_det=PlanChangeDet::PlanDet($account_id);

			$num_of_days=date("t");

			$plan_costDet=PlanChangeDet::PlanCostDet($plan_det["used_days"],$plan_det["plan_code"],$num_of_days);

			$usage=PlanChangeDet::DataUsage($account_id);
			
			$prorata_balance=PlanChangeDet::prorataBalance($plan_costDet["plan_data"],$usage["total_usage"],$plan_costDet["normal_usage"],
											$plan_costDet["plan_cost"],$num_of_days,$plan_det["used_days"],$plan_costDet["monthly_rental"]);

			if($prorata_balance<=0){
				$prorata_balance=1;
			}

			$bill_balance=PlanChangeDet::BillBalance($account_id);
        
         if(count($plan_det) != 0){
			$response= array('found' => "true",
				'old_plan_code'=> $plan_det["plan_code"],
				'old_plan'=> $usage["plan"],
				'bill_balance'=> $bill_balance,
				'start_date'=> $plan_det["plan_start_date"],
				'gb_percent' => $usage["total_usage"] ,
				'prorate_balance' => $prorata_balance,
				'used_days' => $plan_det["used_days"],
				);
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));		
	}
 
	public function fetchPlanDet(){
			$plan_code = Input::get('plan_code');
			$prorata_bal = Input::get('prodata_bal');
			$account_id = Input::get('account_id');
			$plan_start = Input::get('plan_start');

			$plan= Plan::where('account_id','=',$account_id)->where('plan_start_date','<=',$plan_start)
															->where('plan_end_date','>=',$plan_start)->get()->first();
			$plan_det=PlanChangeDet::PlanDet($account_id);
			
			$bill_bal=PlanChangeDet::BillBalance($account_id);
			
			$num_of_days=date("t");
			
			$plan_costDet=PlanChangeDet::PlanCostDet($plan_det["used_days"],$plan_code,$num_of_days);
			
			$new_plan_cost =  round($plan_costDet["plan_cost"] + ($plan_costDet["plan_cost"] * 0.1400));
			
			$prorata=PlanChangeDet::ProrataDiscount($account_id,$plan_costDet["month_sub"],$plan_costDet["plan_data"],
									$new_plan_cost,$plan_det["new_plan_days"],$plan_det["used_days"],$prorata_bal);
			
			$payable_amt = $bill_bal+$prorata["plan_amount"];
			
					if($payable_amt <= 0){
						$payable_amt = 1;
					}

 			if(count($plan_det)!=0){
			$response = array(
						'found' => "true",
						'plan_cost_tax' => $new_plan_cost,
						'prorata_cost' => $prorata["prorata_cost"],
						'prorata_dis' => $prorata["prorata_dis"],
						'plan_amt' => $prorata["plan_amount"],
						'payable_amt' => $payable_amt,
                    );
				return Response::json($response);
			}
			return Response::json(array('found' => "false"));

	}

  	public function monthSub(){

		$month_sub = Input::get('month_sub');
		$plan_list = PlanCostDetail::where('subs','=',$month_sub)
									->where('plan_group','=','Normal')
									->whereNotBetween('plan_code',['1459','1460'])->get();

		foreach($plan_list as $row){

			$plan_code = $row['plan_code'];
			$plan = $row['plan_desc'];
			$subs[$plan_code] = $plan;
		}
		$subs['0'] = 'Select plan';
		echo json_encode($subs);
    }
    public function store(){
    	$plan_det = PlanCostDetail::where('plan_code','=',Input::get('old_plan_code'))->get()->first();
		$plan_start_date=Input::get('plan_start_date');
		$bill=Bill::where('account_id','=',Input::get('account_id'))->orderBy('bill_no','desc')->first();

		if(count($bill)!=0){
			$for_month=$bill->for_month;	
			$plaChange=PlanChangeDetail::where('bill_no',$bill->bill_no)->where('account_id',Input::get('account_id'))->first();
	    	if(count($plaChange)!=0){
				$plaChange->account_id = Input::get('account_id');
				$plaChange->old_plan_code = Input::get('old_plan_code');
				$plaChange->used_days = Input::get('used_days');
				$plaChange->data_usage = Input::get('gb_percent');
				$plan_code = Input::get('new_plan_code');
				$new_plan = PlanCostDetail::where('plan_code','=',$plan_code)->get()->first()->plan_desc;
				$plaChange->new_plan_code = $plan_code;
				$plaChange->plan_amount = Input::get('plan_amount');
				$plaChange->bill_no =$bill->bill_no;

				$payable_amount = Input::get('payable_amount');
				if($payable_amount<=0){
					$payable_amount=1;
				}

				$plaChange->payable_amount=$payable_amount;
				$plaChange->prorate_cost = Input::get('prorata_cost');
				$plaChange->prorate_discount = Input::get('prorata_discount');
				$plaChange->prorate_balance = Input::get('prorata_balance');
				$plaChange->rem_balance = Input::get('bill_balance');
				$plaChange->save();

				if($bill->bill_start_date == $plan_start_date){
						
						$planBill=PlanChangeDetail::billChange($bill->bill_no,$plan_code,NULL);

						$this->PlanChange($plaChange->new_plan_code,Input::get('account_id'),$plan_start_date,$bill->bill_no);

				
				}else if($bill->bill_start_date > $plan_start_date){
						
						$OtherCharges=PlanChangeDetail::OtherCharges($plaChange->other_charges_id,Input::get('account_id'),$payable_amount,$bill->bill_no,$for_month,$plaChange->id,NULL);
						$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Input::get('account_id'),$for_month,$OtherCharges->amount,$plan_code,$plan_start_date);

					$bill_new=Bill::where('account_id','=',$bill->account_id)
	              				 ->where('for_month',date('M-y',strtotime('+1 month',strtotime($bill->for_month))))->get()->first();
	              	if($bill_new){
	              		$planBill=PlanChangeDetail::billChange($bill_new->bill_no,$plan_code,NULL);
	              	}

				}else if($bill->bill_start_date < $plan_start_date) {
						$OtherCharges=PlanChangeDetail::OtherCharges($plaChange->other_charges_id,Input::get('account_id'),$payable_amount,$bill->bill_no,$for_month,$plaChange->id,NULL);
						$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Input::get('account_id'),$for_month,$OtherCharges->amount,$plan_code,$plan_start_date);
				}

			}else{
				$plandet = new PlanChangeDetail();
				$plandet->account_id = Input::get('account_id');
				$plandet->old_plan_code = Input::get('old_plan_code');
				$plandet->used_days = Input::get('used_days');
				$plandet->data_usage = Input::get('gb_percent');
				$plan_code = Input::get('new_plan_code');
				$new_plan = PlanCostDetail::where('plan_code','=',$plan_code)->get()->first()->plan_desc;
				$plandet->new_plan_code = $plan_code;
				$plandet->plan_amount = Input::get('plan_amount');
				$plandet->bill_no =$bill->bill_no;

				$payable_amount = Input::get('payable_amount');
				if($payable_amount<=0){
					$payable_amount=1;
				}
				$plandet->payable_amount=$payable_amount;
				$plandet->prorate_cost = Input::get('prorata_cost');
				$plandet->prorate_discount = Input::get('prorata_discount');
				$plandet->prorate_balance = Input::get('prorata_balance');
				$plandet->rem_balance = Input::get('bill_balance');
				$plandet->last_amount_before_due_date =$bill->amount_before_due_date;
				$plandet->last_plan_code =Input::get('old_plan_code');

				$plan_last_month=date("M-y",strtotime('-1 month',strtotime($bill->for_month)));

				$account_bill=Bill::where('account_id',$bill->account_id)->get();
				$last_bill=Bill::where('account_id',$bill->account_id)->where('for_month',$plan_last_month)->first();
			
				if(count($account_bill)>=2 && count($last_bill)!=0){
					$plandet->last_bill_no = $last_bill->bill_no;
				}else{
					$plandet->last_bill_no = $bill->bill_no;
				}

				$plandet->save();

				if($bill->bill_start_date == $plan_start_date){
				
						$planBill=PlanChangeDetail::billChange($bill->bill_no,$plan_code,NULL);

						$this->PlanChange($plandet->new_plan_code,Input::get('account_id'),$plan_start_date,$bill->bill_no);

				}else if($bill->bill_start_date > $plan_start_date){
				
						$OtherCharges=PlanChangeDetail::OtherCharges(NULL,Input::get('account_id'),$payable_amount,$bill->bill_no,$for_month,$plandet->id,NULL);
						$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Input::get('account_id'),$for_month,$OtherCharges->amount,$plan_code,$plan_start_date);

					$bill_new=Bill::where('account_id','=',$bill->account_id)
	              				 ->where('for_month',date('M-y',strtotime('+1 month',strtotime($bill->for_month))))->get()->first();
	              	if($bill_new){
	              		$planBill=PlanChangeDetail::billChange($bill_new->bill_no,$plan_code,NULL);
	              	}

				}else if($bill->bill_start_date < $plan_start_date) {
						$OtherCharges=PlanChangeDetail::OtherCharges(NULL,Input::get('account_id'),$payable_amount,$bill->bill_no,$for_month,$plandet->id,NULL);
						$planBill=PlanChangeDetail::billUpdate($OtherCharges->id,Input::get('account_id'),$for_month,$OtherCharges->amount,$plan_code,$plan_start_date);
				}

			
		}
			$data['account_id']=Input::get('account_id');
			$data['bill_no']=$planBill->bill_no;
			$amount_pay=$planBill->amount_before_due_date-$planBill->amount_paid;
			if($amount_pay <= 0){
				$amount_to_pay=1;
			}else{
				$amount_to_pay=$amount_pay;	
			}
			$data['amount']=$amount_to_pay;
			$data['topup_id']=NULL;
			//$data['new_plan_code']=$plan_code;

			return View::make('admin.payments.planchange_topup_pay',$data);
			}else{
			return Redirect::back()->with("failure","Bill yet to be not generated Plan Change is not possible");
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