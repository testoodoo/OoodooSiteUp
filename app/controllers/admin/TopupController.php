<?php

namespace Admin;
use View,TopupCostDetail,Input,Plan,Response,TopupDetail,DataUsage,Validator,Redirect,Jsubs,PlanChangeDetail,Bill,Adjustment,TopupDet,PlanCostDetail,DB,Datatables;

class TopupController extends \BaseController {

	
	public function index(){
		$data['plan']=NULL;
		$data['topup']=NULL;
		$data['waiver']=NULL;
		return View::make('admin.topup.index',$data);		
	}

	public function WaiverTopup(){
		$data['plan']=NULL;
		$data['topup']=NULL;
		$data['waiver']="waiver";
		return View::make('admin.topup.index',$data);		
	}

	public function showData(){

		$account_id=Input::get('account_id');
		$waiver=Input::get('waiver');

		if($waiver){
			$data['waiver']=$waiver;
		}else{
			$data['waiver']=NULL;
		}

		$PlanDetails = Plan::where('account_id','=',$account_id)->get()->first();
		if(count($PlanDetails) != 0){
			$data['plan']=$PlanDetails;
			$data['plan_det']=explode(' ',PlanCostDetail::where('plan_code',$PlanDetails->plan_code)->first()->plan_desc);
			$data['topup']=TopupCostDetail::where('speed',$data['plan_det'][0])->get();
			if($data['plan_det'][0]=="4"){
				return Redirect::to('admin/topup/index')->with("failure","Topup not supported for this plan");
			}
			return View::make('admin.topup.index',$data);

       	}else{
			$data['plan']=NULL;
			$data['topup']=NULL;
			return Redirect::to('admin/topup/index')->with("failure","Account Not Found");
       	}
	}

	public function store(){
        
        $speed=Input::get('speed');
        $total_data=Input::get('total_data');
        $total_cost=Input::get('total_cost');
        $account_id=Input::get('account_id');
        $old_plan_code=Input::get('old_plan_code');
        $data_usage=Jsubs::where('account_id','=',$account_id)->get()->first();
        if($data_usage)
        {
        	$data_used=PlanChangeDetail::data_usage_in_gb($data_usage->bytes_total);
        }else{
        	$data_used=0;
        }
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

		$bill=Bill::where('account_id','=',Input::get('account_id'))->where('for_month','=',$for_month)->get()->first();
		$jsubs=Jsubs::where('account_id',$account_id)->first();

		if(count($bill)!=0 && count($jsubs)!=0){

			    if($total_cost==$totalcost)
			    {

			    	if(Input::get('waiver')=="waiver"){

			    		$topup_api = new TopupDet();
						$topup_api->account_id = $account_id;
						$topup_api->plan_code = Input::get('old_plan_code');
						$topup_api->plan=PlanCostDetail::where('plan_code',$topup_api->plan_code)->first()->plan_desc;
						$topup_api->data_usage = $data_used;
						$topup_api->jaccount_no = $jsubs->jaccount_no ;
						$topup_api->topup_data = Input::get('total_data');
						$topup_api->status ="pending";
						$topup_api->topup_date =date("Y-m-d");
					    $topup_api->save();

					    return Redirect::to('admin/topup/topupdetails')->with("success","Topup details added successfully"); 

			    	}else{
					
						$topup_det=TopupDetail::where('bill_no',$bill->bill_no)->where('account_id',$account_id)->first();
						$topup_id ='100555'. sprintf("%04s", count(TopupDetail::all()));
						$topup_update=TopupDet::where('account_id',$account_id)->where('status','payment pending')->first();


						if($topup_det && $topup_update){

							$topup_det->account_id=$account_id;
					        $topup_det->old_plan_code=$old_plan_code;
					        $topup_det->data_usage=$data_used;
					        $topup_det->speed=$speed;
					        $topup_det->cost=$totalcost;
					        $topup_det->data=$totaldata;
					    	$topup_det->desc=json_encode($desc);
					    	$topup_det->topup_id=$topup_id;
					        $topup_det->save();

					        $topup_update->account_id = $account_id;
							$topup_update->plan_code = Input::get('old_plan_code');
							$topup_update->plan=PlanCostDetail::where('plan_code',$topup_det->old_plan_code)->first()->plan_desc;
							$topup_update->data_usage = $topup_det->data_usage;
							$topup_update->jaccount_no = $jsubs->jaccount_no ;
							$topup_update->topup_data = Input::get('total_data');
							$topup_update->status ="payment pending";
							$topup_update->topup_date =date("Y-m-d");
						    $topup_update->save();

						$OtherCharges=PlanChangeDetail::OtherCharges($topup_det->other_charges_id,$account_id,$totalcost,$bill->bill_no,$for_month,NULL,$topup_det->id);
						
						}else{

					        $plan=new TopupDetail();
					        $plan->account_id=$account_id;
					        $plan->old_plan_code=$old_plan_code;
					        $plan->data_usage=$data_used;
					        $plan->speed=$speed;
					        $plan->cost=$totalcost;
					        $plan->data=$totaldata;
					    	$plan->desc=json_encode($desc);
					    	$plan->bill_no=$bill->bill_no;
					    	$plan->topup_id=$topup_id;
					        $plan->save();

					        $topup_api = new TopupDet();
							$topup_api->account_id = $account_id;
							$topup_api->plan_code = Input::get('old_plan_code');
							$topup_api->plan=PlanCostDetail::where('plan_code',$plan->old_plan_code)->first()->plan_desc;
							$topup_api->data_usage = $data_used;
							$topup_api->jaccount_no = $jsubs->jaccount_no ;
							$topup_api->topup_data = Input::get('total_data');
							$topup_api->status ="payment pending";
							$topup_api->topup_date =date("Y-m-d");
						    $topup_api->save();
						
						$OtherCharges=PlanChangeDetail::OtherCharges(NULL,$account_id,$totalcost,$bill->bill_no,$for_month,NULL,$plan->id);

						}

						$planBill=PlanChangeDetail::billUpdateTopup($OtherCharges->id,$account_id,$for_month,$totalcost);
						
						$amount_pay=$planBill->amount_before_due_date-$planBill->amount_paid;
						if($amount_pay <=0){
							$amount_to_pay=1;
						}else{
							$amount_to_pay=$amount_pay;
						}
						
				        $data['amount']=$amount_to_pay;
				        $data['account_id']=$account_id;
					    $data['topup_id']=$topup_id;
					    $data['bill_no']=$bill->bill_no;
						

				  		return View::make('admin.payments.planchange_topup_pay',$data);
			  		}		
			    }else{
					return Redirect::to('admin/topup/index')->with("failure","Enter wrong Amount");   
			    }
		}else{
			return Redirect::to('admin/topup/index')->with("failure","Bill yet to be not generated Plan Change is not possible and jsubs");
		}
	}


	

	public function PlanDetails(){
		$account_id=Input::get('account_id');
		$PlanDetails = Plan::where('account_id','=',$account_id)->get()->first();
		if(count($PlanDetails) != 0){
			$response= array('found' => "true",
				'plan_name'=>$PlanDetails->plan,
				'plan_start_date'=>$PlanDetails->plan_start_date,
				'plan_end_date'=>$PlanDetails->plan_end_date,
               );
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

	public function TopupDetails(){
		return View::make('admin.topup.topup_det');
	}

	public function TopupDetailsAjax(){
		$topup_det= DB::table('topup_details')->select('id','account_id','plan','topup_date',
			'data_usage','topup_data','status','error')->orderBy('id','desc');
        										
        $topup = Datatables::of($topup_det)->make();
       
        return $topup;
	}
}