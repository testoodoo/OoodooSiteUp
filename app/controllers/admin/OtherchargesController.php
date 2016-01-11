<?php
namespace Admin;
use View,Role,Bill,Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment,OtherCharges,Datatables;
use Billinformation,Discount;

class OtherchargesController extends \BaseController {


	public function index(){
		$data['othercharges'] = OtherCharges::paginate(15);
		return View::make('admin.othercharges.index',$data);
	}

	public function indexAjax(){
		$bill= DB::table('other_charges')->select('id','account_id','for_month','amount','remarks')->orderBy('id','desc');

        $bill_det = Datatables::of($bill)->addColumn('is_considered','@if(DB::table("other_charges")->where("id",$id)->first()->is_considered)
														<span class="green bolder"> <span class="fa fa-check fa-2x"></span></span>
													@else
														<span class="red bolder"> <span class="fa fa-close fa-2x"></span></span>
													@endif',false)
        								->addColumn('Edit','<div class="hidden-sm hidden-xs btn-group">
																<a href="othercharges/edit/{{$id}}">
																	<i class="label label-success arrowed">edit</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();

        return $bill_det;
	}

	public function create(){
		$data['othercharges'] = new OtherCharges();
		return View::make('admin.othercharges.create',$data);
	}

	public function store(){
		if(substr(Input::get('account_id'),0,5)== "OFCHN"){
			$plans = Plan::where('account_id','=',Input::get('account_id'))->get();
			$plan = $plans->first();

			$for_month=Adjustment::formonth($plan->plan_start_date);
			
			$othercharges = new OtherCharges();
			$othercharges->account_id = Input::get('account_id');
			$othercharges->amount = Input::get('amount');
			$othercharges->for_month = $for_month;
	        $othercharges->date = date("Y-m-d");
			$othercharges->remarks = Input::get('remarks');
			$othercharges->is_considered = Input::get('is_considered',0);		
			$othercharges->save();

			$bill_info=Discount::othercharges($othercharges->id,$othercharges->account_id,$othercharges->for_month);
			
			$billUpdate=Adjustment::billUpdate($othercharges->id,$othercharges->account_id,$othercharges->for_month,NULL,NULL,NULL,$othercharges->amount,NULL,NULL);


			return Redirect::route('admin.othercharges.index')
					->with('success','OtherCharges Created Succesfully');
		}
		return Redirect::route('admin.othercharges.index')
				->with('failure','Account id Not Vaild');
	}

	public function edit($id) {
		$othercharges = OtherCharges::find($id);
		if (!is_null($othercharges)) {
			$data['othercharges'] = $othercharges;
			return View::make('admin.othercharges.edit',$data);
		}
		return Redirect::route('admin.othercharges.index')
				->with('failure','Data Not Found');
	}

	public function update(){
		$othercharges = OtherCharges::find(Input::get('id'));
		if (!is_null($othercharges)) {
			$othercharges->account_id = Input::get('account_id');
			$othercharges->amount = Input::get('amount');
			$othercharges->for_month = Input::get('for_month');
			$othercharges->remarks = Input::get('remarks');
			$othercharges->is_considered = Input::get('is_considered',0);
			$othercharges->save();

		$bill=Bill::where('account_id',$othercharges->account_id)->get();
			if(count($bill)>=2){
				$for_month=date('M-y',strtotime('-1 month',strtotime($othercharges->for_month)));
			}else{
				$for_month=NULL;
			}
		$bill_info=Discount::otherchargesUpdate($othercharges->id);
		$billUpdate=Adjustment::billUpdate($othercharges->id,$othercharges->account_id,$othercharges->for_month,NULL,NULL,NULL,$othercharges->amount,$for_month,"update");
			
			return Redirect::route('admin.othercharges.index')
				->with('success','OtherCharges Updated Succesfully');
		}
		return Redirect::route('admin.othercharges.index')
				->with('failure','Data Not Found');
	}
	
	public function fetchOtherchargeCostDetails(){
		$for_month = Input::get('for_month');
		$account_id = Input::get('account_id');
		$othercharges = OtherCharges::where('account_id','=',$account_id)
		               ->where('for_month','=',$for_month)->get();
		                $sum=0;
		                      foreach ($othercharges as $key => $value) {
		                          $sum+=(int)$value->amount;
		                      }

         if(count($othercharges) != 0) {
			$response= array('found' => "true",
				'othercharges'=>$sum,
				);
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

}