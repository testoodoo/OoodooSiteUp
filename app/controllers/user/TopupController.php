<?php
namespace User;
use Auth, TopupCostDetail, DataUsage, Input, Plan, Redirect, TopupDetail, BaseController, View, Bill, PlanChangeDetail,Jsubs,User,TopupDet,PlanCostDetail;
class TopupController extends BaseController {

	public function topup(){
		$account_id = Auth::user()->get()->account_id;
		$data['old_plan_code'] = Plan::where('account_id','=',$account_id)->get()->first()->plan_code;
		$data["speed_value"]=explode(' ',PlanCostDetail::where('plan_code','=',$data['old_plan_code'])->get()->first()->plan_desc);
		
		$data['topup'] = TopupCostDetail::where('speed',$data["speed_value"][0])->distinct()->get(array('speed'));
		
		$data['speed_mbps'] = $speed_mbps  = Input::get('speed_mbps');
		
		if($speed_mbps != NULL){
			$data['data_gb'] = $data_gb = TopupCostDetail::distinct()->where('speed','=',$speed_mbps)->get();
		}
		else{
			$data['data_gb'] = NULL;
		}
		
		$data_usage=Jsubs::where('account_id','=',$account_id)->get()->first();
        if($data_usage)
        {
        	$data['data_used']=PlanChangeDetail::data_usage_in_gb($data_usage->bytes_total);
        }else{
        	$data['data_used']=0;
        }

		return View::make('user.topup.topup', $data);
	}

	public function topup_store(){
		$speed = Input::get('speed_mbps');
		$total_cost_val = Input::get('total_cost');

        $topup = TopupCostDetail::where('speed','=',$speed)->get();
        foreach ($topup as $key => $value) {
        	$gb[]=Input::get('gb'.$value->data);
        	$gbvalue[]=Input::get('gbr'.$value->data);
        	$gbcost[]=$value->cost;

	    }
	    for ($i=0; $i < count($gbcost) ; $i++) { 
        	$gb_cost=$gbvalue[$i];
        	$gb_data=$gb[$i];
        	$desc[$gb_data]=$gb_cost;
	    }
        
	  for ($i=0; $i < count($gbcost) ; $i++) { 
	          $data[]=(int)$gb[$i]*(int)$gbvalue[$i];
	          $cost[]=(int)$gbvalue[$i]*(int)$gbcost[$i];
	    }
	    $totaldata=0;
	    $totalcost=0;
	    for ($i=0; $i < count($cost) ; $i++) { 
	         $totaldata+=$data[$i];
	         $totalcost+=$cost[$i];
	    }

	    $date=date('Y-m-d');
		$current_day=date('t',strtotime($date));
		if(25 >= $current_day){
			$for_month=date("M-y", strtotime("-1 month"));	
		}else{
			$for_month=date("M-y");	
		}


	    if($total_cost_val == $totalcost)
	    {
	    	$bill=Bill::where('account_id','=',Auth::user()->get()->account_id)->where('for_month','=',$for_month)->get()->first();
			$jsubs=Jsubs::where('account_id',Auth::user()->get()->account_id)->first();
	    	
	    	if(count($bill)!=0 && count($jsubs)!=0){
			$topup_id = substr(Auth::user()->get()->account_id, -3) .'555'. sprintf("%04s", count(TopupDetail::all()));
			$topup_det=TopupDetail::where('bill_no',$bill->bill_no)->where('account_id',Auth::user()->get()->account_id)->first();
			$topup_update=TopupDet::where('account_id',Auth::user()->get()->account_id)->where('status','payment pending')->first();
					
					if($topup_det && $topup_update){

						$topup_det->account_id=Auth::user()->get()->account_id;
				        $topup_det->old_plan_code=Input::get('old_plan_code');
				        $topup_det->data_usage=Input::get('data_used');
				        $topup_det->speed=Input::get('speed_mbps');
				        $topup_det->cost=Input::get('total_cost');
				        $topup_det->data=Input::get('total_data');
				        $payable_amount = Input::get('total_cost');
				    	$topup_det->desc=json_encode($desc);
				    	$topup_det->topup_id=$topup_id;
				        $topup_det->save();

				        $topup_update->account_id = Auth::user()->get()->account_id;
						$topup_update->plan_code = Input::get('old_plan_code');
						$topup_update->plan=PlanCostDetail::where('plan_code',$topup_det->old_plan_code)->first()->plan_desc;
						$topup_update->data_usage = $topup_det->data_usage;
						$topup_update->jaccount_no = $jsubs->jaccount_no ;
						$topup_update->topup_data = Input::get('total_data');
						$topup_update->status ="payment pending";
						$topup_update->topup_date =date("Y-m-d");
					    $topup_update->save();

					$OtherCharges=PlanChangeDetail::OtherCharges($topup_det->other_charges_id,Auth::user()->get()->account_id,$totalcost,$bill->bill_no,$for_month,NULL,$topup_det->id);
					
					}else{
						
						$topup = new TopupDetail();
						$topup->account_id = Auth::user()->get()->account_id;
						$topup->old_plan_code = Input::get('old_plan_code');
						$topup->data_usage =Input::get('data_used');
						$topup->speed = Input::get('speed_mbps');
						$topup->data = Input::get('total_data');
						$payable_amount = Input::get('total_cost');
						$topup->cost = $payable_amount;
						$topup->desc = json_encode($desc);
					    $topup->topup_id=$topup_id;
					    $topup->bill_no=$bill->bill_no;
					    $topup->save();

					    $topup_api = new TopupDet();
						$topup_api->account_id = Auth::user()->get()->account_id;
						$topup_api->plan_code = Input::get('old_plan_code');
						$topup_api->plan=PlanCostDetail::where('plan_code',$topup->old_plan_code)->first()->plan_desc;
						$topup_api->data_usage = Input::get('data_used');
						$topup_api->jaccount_no = $jsubs->jaccount_no ;
						$topup_api->topup_data = Input::get('total_data');
						$topup_api->status ="payment pending";
						$topup_api->topup_date =date("Y-m-d");
					    $topup_api->save();

					$OtherCharges=PlanChangeDetail::OtherCharges(NULL,Auth::user()->get()->account_id,$totalcost,$bill->bill_no,$for_month,NULL,$topup->id);

					}

					$planBill=PlanChangeDetail::billUpdateTopup($OtherCharges->id,Auth::user()->get()->account_id,$for_month,$totalcost);

					$amount_pay=$planBill->amount_before_due_date-$planBill->amount_paid;
					if($amount_pay <=0){
						$amount_to_pay=1;
					}else{
						$amount_to_pay=$amount_pay;
					}
			
			return Redirect::to('payment/payment_confirm')
				->with('bill_no',$planBill->bill_no)
				->with('payable_amount', $amount_to_pay);
			}else{
				return Redirect::back()->with('failure','Bill yet to be generated topup not possible and jsubs');
			}

	    }else{
	    	return Redirect::back()->with('failure','Invalid amount, Please try again.');
	    }



	}

}