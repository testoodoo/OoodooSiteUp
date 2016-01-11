<?php
namespace Admin;
use View,Role,Bill,Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment,DeviceCost,Datatables;
use Billinformation,Discount;

class DevicecostController extends \BaseController {


	public function index(){
		$data['devicecosts'] = DeviceCost::paginate(15);
		return View::make('admin.devicecost.index',$data);
	}

	public function indexAjax(){
		$bill= DB::table('device_costs')->select('id','account_id','for_month','amount','remarks')->orderBy('id','desc');

        $bill_det = Datatables::of($bill)->addColumn('is_considered','@if(DB::table("device_costs")->where("id",$id)->first()->is_considered)
														<span class="green bolder"> <span class="fa fa-check fa-2x"></span></span>
													@else
														<span class="red bolder"> <span class="fa fa-close fa-2x"></span></span>
													@endif',false)
        								->addColumn('Edit','<div class="hidden-sm hidden-xs btn-group">
																<a href="devicecost/edit/{{$id}}">
																	<i class="label label-success arrowed">edit</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();

        return $bill_det;
	}

	public function create(){
		$data['devicecosts'] = new DeviceCost();
		return View::make('admin.devicecost.create',$data);
	}

	public function store(){
		if(substr(Input::get('account_id'),0,5)== "OFCHN"){
			$plans = Plan::where('account_id','=',Input::get('account_id'))->get();
			$plan = $plans->first();
			$for_month=Adjustment::formonth($plan->plan_start_date);
			$devicecost = new DeviceCost();
			$devicecost->account_id = Input::get('account_id');
			$devicecost->amount = Input::get('amount');
			$devicecost->for_month = $for_month;
	        $devicecost->date = date("Y-m-d");
			$devicecost->remarks = Input::get('remarks');
			$devicecost->is_considered = Input::get('is_considered',0);		
			$devicecost->save();

			$bill_info=Discount::devicecost($devicecost->id,$devicecost->account_id,$devicecost->for_month);
			$billUpdate=Adjustment::billUpdate($devicecost->id,$devicecost->account_id,$devicecost->for_month,NULL,$devicecost->amount,NULL,NULL,NULL,NULL);

			return Redirect::route('admin.devicecost.index')
					->with('success','DeviceCost Created Succesfully');
		}
		return Redirect::route('admin.devicecost.index')
				->with('failure','Account id Not Vaild');
	}

	public function edit($id) {
	         $devicecost = DeviceCost::find($id);
		if (!is_null($devicecost)) {
			$data['devicecosts'] = $devicecost;
			return View::make('admin.devicecost.edit',$data);
		}
		return Redirect::route('admin.devicecost.index')
				->with('failure','Data Not Found');
	}

	public function update(){
		$devicecost = DeviceCost::find(Input::get('id'));
		if (!is_null($devicecost)) {
			$devicecost->account_id = Input::get('account_id');
			$devicecost->amount = Input::get('amount');
			$devicecost->for_month = Input::get('for_month');
			$devicecost->remarks = Input::get('remarks');
			$devicecost->is_considered = Input::get('is_considered',0);
			$devicecost->save();

		$bill=Bill::where('account_id',$devicecost->account_id)->get();
			if(count($bill)>=2){
				$for_month=date('M-y',strtotime('-1 month',strtotime($devicecost->for_month)));
			}else{
				$for_month=NULL;
			}

		$bill_info=Discount::devicecostUpdate($devicecost->id);
		$billUpdate=Adjustment::billUpdate($devicecost->id,$devicecost->account_id,$devicecost->for_month,NULL,$devicecost->amount,NULL,NULL,$for_month,"update");

			return Redirect::route('admin.devicecost.index')
				->with('success','DeviceCost Updated Succesfully');
		}
		return Redirect::route('admin.devicecost.index')
				->with('failure','Data Not Found');
	}
	public function fetchDeviceCostDetails(){
		$for_month = Input::get('for_month');
		$account_id = Input::get('account_id');
		$devicecost = DeviceCost::where('account_id','=',$account_id)
		                    ->where('for_month','=',$for_month)->get();
		                     $sum=0;
		                      foreach ($devicecost as $key => $value) {
		                          $sum+=(int)$value->amount;
		                      }

        if(count($devicecost) != 0) {
			$response= array('found' => "true",
				'devicecost'=>$sum,
				);
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

}