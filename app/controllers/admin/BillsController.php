<?php

namespace Admin;

use View,Role,Bill,Input,DB,Redirect,PlanCostDetail,CusDet,Response,Plan,File,PlanChangeDetail; 
use PaymentTransaction,Config,Billinformation,Adjustment,Discount,DeviceCost,OtherCharges,PDF,Mail,App,Datatables;

class BillsController extends \BaseController {

	protected $config;

	public function index(){
		$data['for_month'] =Bill::distinct()->get(array('for_month'));
		return View::make('admin.bills.index',$data);
	}

	public function billAjax(){

		$for_month=Input::get('for_month');
		$status=Input::get('status');
		$status_s=$areas=explode(',',$status);

				if($for_month && $status){
					$bill= DB::table('bill_det')->where('for_month','=',$for_month)->whereIn('status',$status_s)
						->select('bill_no','account_id','for_month','cust_current_plan',
							'bill_date','due_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_after_due_date','amount_paid','status')->orderBy('bill_no','desc');
					}else{
						$bill= DB::table('bill_det')
						->select('bill_no','account_id','for_month','cust_current_plan',
							'bill_date','due_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_after_due_date','amount_paid','status')->orderBy('bill_no','desc');

					}

        $bill_det = Datatables::of($bill)->addColumn('sendsms','@if($status=="not_paid")
        														<a href="/admin/bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@elseif($status=="partially_paid")
        														<a href="/admin/bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@else
        														-----
        														@endif'
										,false)->addColumn('operations',
												'<span class="hidden-sm hidden-xs action-buttons">
												<a href="\admin/bills/edit/{{$bill_no}}">
												<i class="ace-icon fa fa-pencil bigger-130"></i></a>
												<a href="\admin\bills\view\{{$bill_no}}">
												<i class="red"><i class="ace-icon fa fa-search-plus bigger-130" ></i></a></span>'
													,false)->make();

        return $bill_det;
	}

	public function create(){
		$data['plans'] = PlanCostDetail::all();
		$data['accounts'] = CusDet::all();
		$data['bill'] = new Bill();
		
		return View::make('admin.bills.create',$data);
	}

	public function store(){
		$bill = new Bill();


		// calculate amount after due date and before due date
		//(Previous Bal - Last Payment) + (Total Charges - Adjustments)
		$amount_before_due_date = intval((Input::get('previous_balance') - Input::get('last_payment')) + (Input::get('total_charges') - Input::get('adjustments') ));
		$amount_after_due_date = intval((Input::get('previous_balance') - Input::get('last_payment')) + (Input::get('total_charges') - Input::get('adjustments') ));
		$bill->bill_no= 6;
        
		$bill->account_id = Input::get('account_id');
		$bill->cust_current_plan = Input::get('plan_name');
		$bill->bill_date = Input::get('bill_date');
		$bill->bill_start_date = Input::get('bill_start_date');
		$bill->bill_end_date = Input::get('bill_end_date');
		$bill->due_date = Input::get('due_date');
		$bill->security_deposit = Input::get('security_deposit');
		$bill->prev_bal = Input::get('previous_balance');
		$bill->adjustments = Input::get('adjustments');
		$bill->last_payment = Input::get('last_payment');
		$bill->current_rental = Input::get('current_rental');
		$bill->device_cost = Input::get('device_cost');
		$bill->onetime_charges = Input::get('onetime_charges');
		$bill->discount = Input::get('discount');
		$bill->other_charges = Input::get('other_charges');
		$bill->sub_total = Input::get('sub_total');
		$bill->service_tax = Input::get('service_tax');
		$bill->total_charges = Input::get('total_charges');
		$bill->amount_before_due_date = $amount_before_due_date;
		$bill->amount_after_due_date = $amount_after_due_date;
		$bill->for_month = Input::get('for_month');
		$bill->status = Input::get('status');
		$bill->amount_paid = Input::get('amount_paid');
		//var_dump(Input::get('discount_id'));die;

		 if (Input::get('amount_paid') > 0) {
            if ($amount_before_due_date <= Input::get('amount_paid')) {
                $bill->status = "paid";
            } else if ($amount_before_due_date > Input::get('amount_paid')) {
                $bill->status = "partially_paid";
            }    
        } else {
            $bill->status = "not_paid";
        }


		if ($bill->save()){

			$bills = Bill::where('account_id','=',Input::get('account_id'))
			->orderBy('bill_no', 'desc')->get();

			$get_bill = $bills->first();
			$data['bill'] = Bill::where('account_id','=',Input::get('account_id'))
                      			->orderBy('bill_no', 'desc')->get()->first();

            $data['customer'] = CusDet::where('account_id','=',Input::get('account_id'))->get()->first();

			$bill->billInfo($get_bill->bill_no,$get_bill->account_id,$get_bill->for_month);

			return Redirect::to('admin/bills/view/'.$get_bill->bill_no)->with('success','Bill Succesfully Created');
		}
		return Redirect::back()->withInput()->withErrors($bill->errors());

	}

	public function view($id){
		$bills = Bill::where('bill_no','=',$id)->get()->first();
		if (count($bills) != 0) {
			$for_month = $bills->for_month;
			$account_id = $bills->account_id;
			$data['bill'] = $bills;
			$payment=PaymentTransaction::where('bill_no',$id)->get()->first();

			$bill_in=Billinformation::where('bill_no','=',$id)->get()->first();
			$bill_info=Billinformation::where('bill_no','=',$id)->get();
		if(count($bill_in)!=0)
		{
            if(Billinformation::where('bill_no','=',$id)->sum('device_cost_id')!=0)
            { 
			foreach ($bill_info as $key => $value) {
			$devicecost[]=DeviceCost::where('id','=',$value->device_cost_id)
			                        ->where('for_month','=',$for_month)->get();
                           	}
		            			$data['devicecost']=$devicecost;
				       		}else{
								$data['devicecost']=NULL;
					    }
		    if(Billinformation::where('bill_no','=',$id)->sum('adjustment_id')!=0)
			{
			foreach ($bill_info as $key => $value) {	
			$adjustment[]=Adjustment::where('id','=',$value->adjustment_id)
			                        ->where('for_month','=',$for_month)->get();
			                           }
		                        		$data['adjustment']=$adjustment;
								    }else{
										$data['adjustment']=NULL;
								    }
		   if(Billinformation::where('bill_no','=',$id)->sum('discount_id')!=0)
			{
			foreach ($bill_info as $key => $value) {
		    $discount[]=Discount::where('id','=',$value->discount_id)
		                        ->where('for_month','=',$for_month)->get();
		    					}
		                    	$data['discount']=$discount; 
						    }else{
								$data['discount']=NULL;
						    }
		    if(Billinformation::where('bill_no','=',$id)->sum('other_charges_id')!=0)
			{
		    foreach ($bill_info as $key => $value) {
			$othercharges[]=OtherCharges::where('id','=',$value->other_charges_id)
			                            ->where('for_month','=',$for_month)->get();
			                        }
			    					$data['othercharges']=$othercharges;
								}else{
									$data['othercharges']=NULL;
							    }

        	return View::make('admin.bills.view',$data); 
		    
		}
		     $data['adjustments']=NULL;
		     $data['discount']=NULL;
		     $data['devicecost']=NULL;
		     $data['othercharges']=NULL;
        	return View::make('admin.bills.view',$data); 
		}
		return Redirect::to('admin/bills')->with('failure','Bill Not found');
	}

	public function edit($id){
		$bill = Bill::where('bill_no','=',$id);
		if(count($bill) != 0) {
			$bill = $bill->first();
			$data['bill'] = $bill;
			$for_month = $bill->for_month;
			if(strtotime($for_month) < strtotime("Jun-15")){
					$data['service_tax']=0.1236;
			}else{
					$data['service_tax']=0.1400;
			}
			$data['status_list'] = ['paid','partially_paid','not_paid'];
			return View::make('admin.bills.edit',$data);
		}
		return Redirect::route('admin.bills.index')->with('failure','Account Not Found');
	}

	public function update(){
		$bill = Bill::where('bill_no','=',Input::get('bill_no'))->get();
		if(count($bill) != 0) {
			$bill = $bill->first();

			$amount_before_due_date = intval((Input::get('previous_balance') - Input::get('last_payment')) + (Input::get('total_charges') - Input::get('adjustments') ));
			$amount_after_due_date = intval((Input::get('previous_balance') - Input::get('last_payment')) + (Input::get('total_charges') - Input::get('adjustments') ));

			if (Input::get('amount_paid') >= 0) {
	            if ($amount_before_due_date <= Input::get('amount_paid')) {
	                $status = "paid";
	            } else if ($amount_before_due_date > Input::get('amount_paid') && Input::get('amount_paid')!=0 ) {
	                $status = "partially_paid";
	            } else if ($amount_before_due_date > Input::get('amount_paid') && Input::get('amount_paid')==0) {
	                $status = "not_paid";
	            }     
	        } else {
	            $status = "not_paid";
	        }

	        $payment=DB::table('payment_transactions')->where('bill_no','=',Input::get('bill_no'))->where('status','=','success')->get();
	        $sum=0;
	        foreach ($payment as $key => $value) {
	        	$sum+= $value->amount;
	        }
	        if(Input::get('amount_paid') == $sum){

			DB::table('bill_det')->where('bill_no','=',Input::get('bill_no'))
			->update(array(
				'account_id' => Input::get('account_id'), 
				'for_month' => Input::get('for_month'),
				'bill_date' => Input::get('bill_date'),
				'due_date' => Input::get('due_date'),
				'prev_bal' => Input::get('previous_balance'),
				'last_payment' => Input::get('last_payment'),
				'adjustments' => Input::get('adjustments'),
				'amount_paid' => Input::get('amount_paid'),
				'cust_current_plan' => Input::get('plan_name'),
				'bill_start_date' => Input::get('bill_start_date'),
				'bill_end_date' => Input::get('bill_end_date'),
				'security_deposit' => Input::get('security_deposit'),
				'current_rental' => Input::get('current_rental'),
				'device_cost' => Input::get('device_cost'),
				'oneTime_charges' => Input::get('one_time_charges'),
				'discount' => Input::get('discount'),
				'other_charges' => Input::get('other_charges'),
				'sub_total' => Input::get('sub_total'),
				'service_tax' => Input::get('service_tax'),
				'amount_before_due_date' => $amount_before_due_date,
				'amount_after_due_date' => $amount_after_due_date,
				'total_charges' => Input::get('total_charges'),
				'status' => $status
			));	

			}else{
					return Redirect::route('admin.bills.index',array('status' => "all"))
			->with('failure','Payment Amount and Bill Amount paid Not Matched');

			}

			return Redirect::route('admin.bills.index',array('status' => "all"))
					->with('success','Account Successfully Updated');
		}
		return Redirect::route('admin.bills.index',array('status' => "all"))
			->with('failure','Account Not Found');
	}

	public function fetchPlanDetails(){
		$account_id = strtoupper(Input::get('account_id'));
        $plans = Plan::where('account_id','=',$account_id)->get();

		if(count($plans) != 0) {
		$plan = $plans->first();
        $start_date =strtotime($plan->plan_start_date);
		$today_date = strtotime(date("Y-m-d"));
		$used_day = ($today_date - $start_date)/86400;
		//var_dump($used_day);die;
		if($used_day>=25)
		{
			$for_month = date('M-y');
		} else {
			$for_month = date("M-y", strtotime("+1 month") );
		}
		//var_dump($for_month);die;

			$response = array(
						'found' => "true",
						'plan' => $plan->plan,
						'plan_code' => $plan->plan_code,
						'plan_start_date' => $plan->plan_start_date,
						'plan_end_date' => $plan->plan_end_date,
						'for_month' => $for_month
					);
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}

	public function fetchPlanCostDetails(){
		$plan_code = Input::get('plan_code');
		$plan_costs = PlanCostDetail::where('plan_code','=',$plan_code)->get();
		if(count($plan_costs) != 0) {
			$plan_cost = $plan_costs->first();
			$response = array(
						'found' => "true",
						'current_rental' => $plan_cost->plan_cost,
						'device_cost' => $plan_cost->device_cost,
						'onetime_charges' => $plan_cost->onetime_charges,
					);
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}
    public function notifyUserForBill($bill_no){
		$bill = Bill::where('bill_no','=',$bill_no)->get()->first();

		if(!is_null($bill)) {
			$customer = CusDet::where('account_id','=',$bill->account_id)->get()->first();
				
			$senderId = "OODOOP";
			$message = "Hi, $customer->first_name $customer->last_name \n Your Data Usage Bill amount is $bill->amount_before_due_date is pending! \n if u already paid please ignore!! \n For any assistance please contact our customer care at +91 8940808080";
			$mobileNumber = $customer->phone;		

			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);
			if ($return) {
				return Redirect::back()->with('success','Message Send Successfully');
			} else {
				return Redirect::back()->with('failure','Message Send Failure');
			}
		}
		return Redirect::to('/admin/bills')->with('failure','Bill No Not Found');
	}


	public function userBill(){
		$account_id=Input::get('account_id');
		$bill= Bill::select('bill_no','for_month','cust_current_plan',
							'bill_date','due_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_after_due_date','amount_paid','status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');

		if(count($bill) != 0){
        $bill_user = Datatables::of($bill)->addColumn('sendsms','@if($status=="not_paid")
        														<a href="bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@elseif($status=="partially_paid")
        														<a href="bills/notify_user_for_bill/{{$bill_no}}">Send SMS</a>
        														@else
        														-----
        														@endif',false)->addColumn('operations',
        															'<button type="submit" class="btn btn-minier btn-primary" onclick="bill({{$bill_no}});" >
									                                    view
									                                    </button>'
      																,false)->make();
				return $bill_user;
			}
				return null;
	    }

	public function Retransaction($bill_no){
				$re_bill=Bill::where('bill_no',$bill_no)->first();
				$re_trans=PaymentTransaction::where('bill_no',$bill_no)->first();
				$amount=PaymentTransaction::where('bill_no',$bill_no)->where('status','success')->sum('amount');
				if(!$re_trans){
					if($re_bill->amount_paid <=0 ){
					$bill_up=Bill::where('account_id',$re_bill->account_id)->where('bill_no','>',$re_bill->bill_no)->orderBy('bill_no','asc')->get();
						$bill=Bill::where('account_id',$re_bill->account_id)->where('bill_no',$re_bill->bill_no)->first();
						$this->UpdateBill($amount,$re_bill->bill_no);
						foreach ($bill_up as $key) {
							$bill_in=Bill::where('bill_no',$key->bill_no)->first();
							$plan=Plan::where('account_id',$key->account_id)->first();
							$billchange=PlanChangeDetail::billChange($key->bill_no,$plan->plan_code,$bill_in->current_rental);
							if(count($billchange)==2){
								if($billchange['status']=='false'){
									DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->update(array('amount_paid' =>0,'status' => "not_paid"));
									return Redirect::back()->with('failure',$billchange['name'].' amount not matched with bill');
								}
							}
						}
						return Redirect::route('admin.bills.index')->with('success','Updated Successfully');
					}else{
						return Redirect::back()->with('failure','payment not found');
					}
				}else{
					$bill_up=Bill::where('account_id',$re_trans->account_id)->where('bill_no','>',$re_trans->bill_no)->orderBy('bill_no','asc')->get();
						$bill=Bill::where('account_id',$re_trans->account_id)->where('bill_no',$re_trans->bill_no)->first();
						$this->UpdateBill($amount,$re_trans->bill_no);
						foreach ($bill_up as $key) {
							$bill_in=Bill::where('bill_no',$key->bill_no)->first();
							$plan=Plan::where('account_id',$key->account_id)->first();
							$billchange=PlanChangeDetail::billChange($key->bill_no,$plan->plan_code,$bill_in->current_rental);
							if(count($billchange)==2){
								if($billchange['status']=='false'){
									DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->update(array('amount_paid' =>0,'status' => "not_paid"));
									return Redirect::back()->with('failure',$billchange['name'].' amount not matched with bill');
								}
							}
						}
						return Redirect::route('admin.bills.index')->with('success','Updated Successfully');

				}
	}

	public function UpdateBill($amount,$bill_no){
		$bill=Bill::where('bill_no','=',$bill_no)->get()->first();
		$amount_paid=(int)$amount;
					if($bill->amount_before_due_date<=$amount){
						DB::table('bill_det')->where('bill_no','=',$bill_no)
						->update(array(
							'amount_paid' => $amount_paid,
							'status' => "paid"
						));
					}else if($amount==0){
						DB::table('bill_det')->where('bill_no','=',$bill_no)
						->update(array(
							'amount_paid' => $amount_paid,
							'status' => "not_paid"
						));
					}else{
						DB::table('bill_det')->where('bill_no','=',$bill_no)
						->update(array(
							'amount_paid' => $amount_paid,
							'status' => "partially_paid"
						));
					}		
	}


}