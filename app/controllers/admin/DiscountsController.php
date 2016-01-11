<?php
namespace Admin;
use View,Role,Bill,Input,DB,Redirect,PlanCostDetail,CustDet,Response,Plan,Adjustment,Discount,Datatables;
use Billinformation;

class DiscountsController extends \BaseController {


	public function index(){
		$data['discounts'] = Discount::paginate(15);
		return View::make('admin.discounts.index',$data);
	}

	public function indexAjax(){
		$bill= DB::table('discounts')->select('id','account_id','for_month','amount','remarks')->orderBy('id','desc');

        $bill_det = Datatables::of($bill)->addColumn('is_considered','@if(DB::table("discounts")->where("id",$id)->first()->is_considered)
														<span class="green bolder"> <span class="fa fa-check fa-2x"></span></span>
													@else
														<span class="red bolder"> <span class="fa fa-close fa-2x"></span></span>
													@endif',false)
        								->addColumn('Edit','<div class="hidden-sm hidden-xs btn-group">
																<a href="discounts/edit/{{$id}}">
																	<i class="label label-success arrowed">edit</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();

        return $bill_det;
	}

	public function create(){
		$data['discounts'] = new Discount();
		return View::make('admin.discounts.create',$data);
	}

	public function store(){

		if(substr(Input::get('account_id'),0,5)== "OFCHN"){
			$plans = Plan::where('account_id','=',Input::get('account_id'))->get();
			$plan = $plans->first();

			$for_month=Adjustment::formonth($plan->plan_start_date);
			$discount = new Discount();
			$discount->account_id = Input::get('account_id');
			$discount->amount = Input::get('amount');
			$discount->for_month = $for_month;
	        $discount->date = date("Y-m-d");
			$discount->remarks = Input::get('remarks');
			$discount->is_considered = Input::get('is_considered',0);		
			$discount->save();
			
			$bill_info=Discount::discounts($discount->id,$discount->account_id,$discount->for_month);
			$billUpdate=Adjustment::billUpdate($discount->id,$discount->account_id,$discount->for_month,NULL,NULL,$discount->amount,NULL,NULL,NULL);


			return Redirect::route('admin.discounts.index')
					->with('success','Discount Created Succesfully');
		}
		return Redirect::route('admin.discounts.index')
				->with('failure','Account id Not Vaild');
	}

	public function edit($id) {
		$discounts = Discount::find($id);
		if (!is_null($discounts)) {
			$data['discounts'] = $discounts;
			return View::make('admin.discounts.edit',$data);
		}
		return Redirect::route('admin.discounts.index')
				->with('failure','Data Not Found');
	}

	public function update(){
		$discount = Discount::find(Input::get('id'));
		if (!is_null($discount)) {
			$discount->account_id = Input::get('account_id');
			$discount->amount = Input::get('amount');
			$discount->for_month = Input::get('for_month');
			$discount->remarks = Input::get('remarks');
			$discount->is_considered = Input::get('is_considered',0);
			$discount->save();

		$bill=Bill::where('account_id',$discount->account_id)->get();
			if(count($bill)>=2){
				$for_month=date('M-y',strtotime('-1 month',strtotime($discount->for_month)));
			}else{
				$for_month=NULL;
			}

		$bill_info=Discount::discountsUpdate($discount->id);
		$billUpdate=Adjustment::billUpdate($discount->id,$discount->account_id,$discount->for_month,NULL,NULL,$discount->amount,NULL,$for_month,"update");
			
			return Redirect::route('admin.discounts.index')
				->with('success','Discount Updated Succesfully');
		}
		return Redirect::route('discountsindex')
				->with('failure','Data Not Found');
	}

	public function fetchDiscountCostDetails(){
		$for_month = Input::get('for_month');
		$account_id = Input::get('account_id');
		$discount   = Discount::where('account_id','=',$account_id)
		             ->where('for_month','=',$for_month)->get();
		              $sum=0;
		                      foreach ($discount as $key => $value) {
		                          $sum+=(int)$value->amount;
		                      }

        if(count($discount) != 0) {
			$response= array('found' => "true",
				'discount'=>$sum,
				);
			
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

}