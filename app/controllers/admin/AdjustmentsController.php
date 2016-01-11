<?php
namespace Admin;
use View,Role,Bill, Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment,Datatables,BillWaiver,Jsubs,PlanChangeDet,PlanChangeDetail,TopupDet;

class AdjustmentsController extends \BaseController {


	public function index(){
		$data['adjustments'] = Adjustment::paginate(15);
		return View::make('admin.adjustments.index',$data);
	}

	public function indexAjax(){
		$bill= DB::table('adjustments')->select('id','account_id','for_month','amount','remarks')->orderBy('id','desc');

        $bill_det = Datatables::of($bill)->addColumn('is_considered','@if(DB::table("adjustments")->where("id",$id)->first()->is_considered)
														<span class="green bolder"> <span class="fa fa-check fa-2x"></span></span>
													@else
														<span class="red bolder"> <span class="fa fa-close fa-2x"></span></span>
													@endif',false)
        								->addColumn('Edit','<div class="hidden-sm hidden-xs btn-group">
																<a href="adjustments/edit/{{$id}}">
																	<i class="label label-success arrowed">edit</i>
																</a>&nbsp;&nbsp;
															</div>',false)->make();

        return $bill_det;
	}

	public function create(){
		$data['adjustment'] = new Adjustment();
		return View::make('admin.adjustments.create',$data);
	}

	public function store(){
		if(substr(Input::get('account_id'),0,5)== "OFCHN"){
			$plans = Plan::where('account_id','=',Input::get('account_id'))->get();
			$plan = $plans->first();
			$for_month=Adjustment::formonth($plan->plan_start_date);
	        $adjustment = new Adjustment();
			$adjustment->account_id = Input::get('account_id');
			$adjustment->for_month =$for_month;
	        $adjustment->amount = Input::get('amount');
	        $adjustment->date = date("Y-m-d");
			$adjustment->remarks = Input::get('remarks');
			$adjustment->is_considered = Input::get('is_considered',0);		
			$adjustment->save();

			$bill_info=Adjustment::adjustments($adjustment->id,$adjustment->account_id,$adjustment->for_month);

			$billUpdate=Adjustment::billUpdate($adjustment->id,$adjustment->account_id,$adjustment->for_month,$adjustment->amount,NULL,NULL,NULL,NULL,NULL);

			return Redirect::route('admin.adjustments.index')
					->with('success','Adjustment Created Succesfully');
		}
		return Redirect::route('admin.adjustments.index')
				->with('failure','Account id Not Vaild');

	}

	public function edit($id) {
		$adjustment = Adjustment::find($id);
		if (!is_null($adjustment)) {
			$data['adjustment'] = $adjustment;
			return View::make('admin.adjustments.edit',$data);
		}
		return Redirect::route('admin.adjustments.index')
				->with('failure','Data Not Found');
	}

	public function update(){
		$adjustment = Adjustment::find(Input::get('id'));
		if (!is_null($adjustment)) {
			$adjustment->account_id = Input::get('account_id');
			$adjustment->amount = Input::get('amount');
			$adjustment->for_month = Input::get('for_month');
			$adjustment->remarks = Input::get('remarks');
			$adjustment->is_considered = Input::get('is_considered',0);
			$adjustment->save();

			$bill=Bill::where('account_id',$adjustment->account_id)->get();
			if(count($bill)>=2){
				$for_month=date('M-y',strtotime('-1 month',strtotime($adjustment->for_month)));
			}else{
				$for_month=NULL;
			}
			
			$bill_info=Adjustment::adjustmentUpdate($adjustment->id);
			$billUpdate=Adjustment::billUpdate($adjustment->id,$adjustment->account_id,$adjustment->for_month,$adjustment->amount,NULL,NULL,NULL,$for_month,"update");


			return Redirect::route('admin.adjustments.index')
				->with('success','Adjustment Updated Succesfully');
		}
		return Redirect::route('admin.adjustments.index')
				->with('failure','Data Not Found');
	}
	
	public function fetchAdjustmentCostDetails(){
		$account_id = Input::get('account_id');
	    $for_month=Input::get('for_month');
        $adjustment = Adjustment::where('account_id','=',$account_id)
		                      ->where('for_month','=',$for_month)->get();
		                      $sum=0;
		                      foreach ($adjustment as $key => $value) {
		                          $sum+=(int)$value->amount;
		                      }
         if(count($adjustment) != 0){
			$response= array('found' => "true",
				'adjustment'=>$sum,
				);
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

	public function billwaiver(){
		return View::make('admin.billwaiver.index');
	}

	public function billwaiverAjax(){

		$bill= DB::table('billwaiver')->select('id','account_id','for_month','amount','waiver_data','remarks')->orderBy('id','desc');

        $bill_det = Datatables::of($bill)->addColumn('Edit','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/billwaiver/edit/{{$id}}">
																	<i class="label label-success arrowed">edit</i>
																</a>&nbsp;&nbsp;
															</div',false)->addColumn('approved','@if(DB::table("billwaiver")->where("id",$id)->first()->is_considered)
																	<i class="label label-primary arrowed">approved</i>
																@else
	        														<div class="hidden-sm hidden-xs btn-group">
																	<a href="/admin/billwaiver/update/{{$id}}">
																		<i class="label label-success arrowed">approve</i>
																	</a>&nbsp;&nbsp;
																	</div>
																@endif',false)->make();

        return $bill_det;
	}

	public function billwaiverCreate(){
		return View::make('admin.billwaiver.create');	
	}

	public function billwaiverStore(){
		if(substr(Input::get('account_id'),0,5)== "OFCHN"){
			$plan = Plan::where('account_id','=',Input::get('account_id'))->get()->first();
			$bill=Bill::where('account_id',Input::get('account_id'))->orderBy('bill_no','desc')->first();

			$plan_cost_det = PlanCostDetail::where('plan_code','=',$plan->plan_code)->get()->first();

			if(Input::get('waiver_no_of_days') && Input::get('waiver_plan_code')){
				$plan_days=Input::get('waiver_no_of_days');
				$waiver_plan_code=Input::get('waiver_plan_code');
			}else{
				$plan_days=0;
				$waiver_plan_code=0;
			}

			$waiver_data=Input::get('waiver_data');
			if($waiver_data){
				if($plan_cost_det->data_gb==0){
					return Redirect::back()
								->with('failure','Unlimited plan Billwaiver Data Not possible');
				}
			}
			
			if(Input::get('waiver_amount')){
				$for_month=Adjustment::formonth($plan->plan_start_date);
			}else{
				$for_month=$bill->for_month;
			}
			
				$plan_start_date=Input::get('waiver_start_date');
				if($plan_days){
					$plan_end_date=date('Y-m-d',strtotime("+".$plan_days." day"));
				}else{
					$plan_end_date=0;
				}
			
	        $billwaiver = new BillWaiver();
			$billwaiver->account_id = Input::get('account_id');
			$billwaiver->for_month =$for_month;
	        $billwaiver->amount = Input::get('waiver_amount');
	        $billwaiver->date = date("Y-m-d");
	        $billwaiver->waiver_start_date = $plan_start_date;
	        $billwaiver->waiver_end_date = $plan_end_date;
	        $billwaiver->current_plan_code = $plan->plan_code;
	        $billwaiver->waiver_plan_code = $waiver_plan_code;
	        $billwaiver->waiver_plan_days = $plan_days;
	        $billwaiver->waiver_data = $waiver_data;
			$billwaiver->remarks = Input::get('remarks');
			$billwaiver->is_considered = Input::get('is_considered',0);		
			if($billwaiver->save()){
					return Redirect::route('admin.billwaiver.index')
							->with('success','billwaiver Created Succesfully');
			}else{
					return Redirect::route('admin.billwaiver.index')
							->with('failure','billwaiver  has been not added');
			}
		}
		return Redirect::route('admin.billwaiver.index')
							->with('failure','Account id Not Vaild');

	}

	public function billwaiverUpdate($id){

		$billwaiver=BillWaiver::where('id',$id)->first();
		if($billwaiver){
			$plan = PlanCostDetail::where('plan_code','=',$billwaiver->current_plan_code)->get()->first();

			$bill=Bill::where('account_id',$billwaiver->account_id)->orderBy('bill_no','desc')->first();
				$Jsubs=Jsubs::where('account_id','=',$billwaiver->account_id)->get()->first();
		        if($Jsubs)
		        {
		        	$data_used=PlanChangeDetail::data_usage_in_gb($Jsubs->bytes_total);
		        }else{
		        	$data_used=0;
		        }

			if($billwaiver->waiver_plan_code){
				$planchange=new PlanChangeDet();
				$planchange->account_id=$billwaiver->account_id;
				$planchange->plan_code=$billwaiver->waiver_plan_code;
				$planchange->plan_name=$plan->plan_desc;
				if($billwaiver->waiver_start_date < date("Y-m-d")){
					$planchange->plan_change_date=date("Y-m-d");
				}else{
					$planchange->plan_change_date=$billwaiver->waiver_start_date;
				}
				$planchange->request_id ="44444";
				$planchange->remarks =$bill->bill_no;
				$planchange->status="pending";
				$planchange->save();
				$plan_days=$billwaiver->waiver_plan_days;
				$billwaiver->waiver_start_date=date("Y-m-d");
				$billwaiver->waiver_end_date=date('Y-m-d',strtotime("+".$plan_days." day"));
			}

			if($billwaiver->amount){
				$adjustment = new Adjustment();
				$adjustment->account_id =$billwaiver->account_id;
				$adjustment->for_month =$billwaiver->for_month;
		        $adjustment->amount = $billwaiver->amount;
		        $adjustment->date = $billwaiver->date;
				$adjustment->remarks = $billwaiver->remarks;
				$adjustment->is_considered =$billwaiver->is_considered;		
				$adjustment->save();
				$bill_info=Adjustment::adjustments($adjustment->id,$adjustment->account_id,$adjustment->for_month);
				$billUpdate=Adjustment::billUpdate($adjustment->id,$adjustment->account_id,$adjustment->for_month,$adjustment->amount,NULL,NULL,NULL,NULL,"update");
			}

			if($billwaiver->waiver_data){
				$topup_api = new TopupDet();
				$topup_api->account_id = $billwaiver->account_id;
				$topup_api->plan_code = $billwaiver->current_plan_code;
				$topup_api->plan=PlanCostDetail::where('plan_code',$billwaiver->current_plan_code)->first()->plan_desc;
				$topup_api->data_usage = $data_used;
				$topup_api->jaccount_no = $Jsubs->jaccount_no ;
				$topup_api->topup_data = $billwaiver->waiver_data;
				$topup_api->status ="pending";
				$topup_api->topup_date =date("Y-m-d");
			    $topup_api->save();	
			}
		$billwaiver->is_considered=1;
		$billwaiver->save();
		return Redirect::route('admin.billwaiver.index')
				->with('success','billwaiver has been approved Succesfully');
		}else{
			return Redirect::route('admin.billwaiver.index')
				->with('failure','billwaiver Not Found');
		}

	}

	public function billwaiverEdit($id){
		$billwaiver=BillWaiver::where('id',$id)->first();
		if($billwaiver){
			if($billwaiver->waiver_plan_code){
				$data['plan']=PlanCostDetail::where('plan_code',$billwaiver->waiver_plan_code)->first()->plan;
			}
			$data['billwaiver']=$billwaiver;
			return View::make('admin.billwaiver.edit',$data);	
		}else{
			return Redirect::route('admin.billwaiver.index')
				->with('failure','billwaiver Not Found');
		}
	}

	public function billwaiverEditUpdate(){
        
        $billwaiver =BillWaiver::where('id',Input::get('id'))->first();
        if($billwaiver){
			$plan = Plan::where('account_id','=',Input::get('account_id'))->get()->first();
			$bill=Bill::where('account_id',Input::get('account_id'))->orderBy('bill_no','desc')->first();

			if(Input::get('waiver_no_of_days') && Input::get('waiver_plan_code')){
				$plan_days=Input::get('waiver_no_of_days');
				$waiver_plan_code=Input::get('waiver_plan_code');
			}else{
				$plan_days=0;
				$waiver_plan_code=0;
			}

			$waiver_data=Input::get('waiver_data');
			
			if(Input::get('waiver_amount')){
				$for_month=Adjustment::formonth($plan->plan_start_date);
			}else{
				$for_month=$bill->for_month;
			}
			
				$plan_start_date=date('Y-m-d');
				if($plan_days){
					$plan_end_date=date('Y-m-d',strtotime("+".$plan_days." day"));
				}else{
					$plan_end_date=0;
				}
			
			$billwaiver->account_id = Input::get('account_id');
			$billwaiver->for_month =$for_month;
	        $billwaiver->amount = Input::get('waiver_amount');
	        $billwaiver->date = date("Y-m-d");
	        $billwaiver->waiver_start_date = $plan_start_date;
	        $billwaiver->waiver_end_date = $plan_end_date;
	        $billwaiver->current_plan_code = $plan->plan_code;
	        $billwaiver->waiver_plan_code = $waiver_plan_code;
	        $billwaiver->waiver_plan_days = $plan_days;
	        $billwaiver->waiver_data = $waiver_data;
			$billwaiver->remarks = Input::get('remarks');
			$billwaiver->is_considered = Input::get('is_considered',0);		
			$billwaiver->save();
				return Redirect::route('admin.billwaiver.index')
						->with('success','billwaiver Updated Succesfully');
		}else{
				return Redirect::route('admin.billwaiver.index')
						->with('failure','billwaiver not Found');
		}

	}


}