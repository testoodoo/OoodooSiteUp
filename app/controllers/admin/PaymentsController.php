<?php

namespace Admin;

use View,Role,Bill, Input,DB,Redirect,PlanCostDetail,CusDet,Response,Plan,CardTransaction,PlanChangeDet,PlanChangeDetils;
use PaymentTransaction,ChequeTransaction,Config,PlanChangeDetail,Auth,Datatables,ActivationDetails,TopupDetail,TopupDet;

class PaymentsController extends \BaseController {

	protected $config;

	public function transactionsList(){
		$data['for_month'] =Bill::distinct()->get(array('for_month'));
		return View::make('admin.payments.transactions_list',$data);
	}

	public function paymentAjax(){

		$status=Input::get('status');
		$status_s=$areas=explode(',',$status);
		
		if($status){
		$payment= DB::table('payment_transactions')->whereIn('status',$status_s)
						->select('id','account_id','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','created_at','payment_type',
								'status')->orderBy('id','desc');
		}else{
		$payment= DB::table('payment_transactions')
						->select('id','account_id','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','created_at','payment_type',
								'status')->orderBy('id','desc');
		}
        $payment_det = Datatables::of($payment)->addColumn('operations',
        													'<span class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
        													<a href="/admin/payments/edit/{{$id}}">
        													<i class="ace-icon fa fa-pencil bigger-130"></i></a>
        													<a href="/admin/payments/show/{{$id}}">
        													<i class="ace-icon fa fa-search-plus bigger-130"></i></span>
															</a>',false)->make();

        return $payment_det;
	}

	public function chequeList(){
			return View::make('admin.payments.cheque_list');	
	}

	public function chequeAjax(){
		$cheque= DB::table('cheque_transactions')->join('payment_transactions', 'cheque_transactions.transaction_id', '=', 'payment_transactions.id')
												->select('cheque_transactions.id','cheque_transactions.cheque_no','cheque_transactions.transaction_id','payment_transactions.account_id','cheque_transactions.cheque_account_no',
												'cheque_transactions.cheque_holder_name','payment_transactions.status','cheque_transactions.cheque_status')->orderBy('cheque_transactions.id','desc');
        $cheque_list= Datatables::of($cheque)->addColumn('operations',
        													'<span class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
        													<a href="/admin/payments/show_cheque/{{$transaction_id}}">
        													<i class="ace-icon fa fa-search-plus bigger-130"></i></span>
															</a>',false)->make();
        return $cheque_list;
	   
	}




	public function getOfflineBill(){
		
		return View::make('admin.payments.offline_bill');	
	}

	public function DuegetOfflineBill(){
		
		return View::make('admin.payments.due_payment_offline');	
	}


	public function show($id){

		$transaction = PaymentTransaction::find($id);
		if (!is_null($transaction)) {
			$data['transaction'] = $transaction;
			return View::make('admin.payments.show',$data);
		}
		return Redirect::route('admin.payments.transactions.index')
							->with('failure','Invalid Transaction ID');

	}

	public function postOfflineBill(){

	    $account_ids=Input::get('account_ids');
	    $bill_nos=Input::get('bill_nos');
	    $amounts=Input::get('amounts');
	    $account_ids_new=Input::get('account_ids_new');
	    $amounts_new=Input::get('amounts_new');
	    $payment_date = Input::get('payment_date');

	    $account_id_of=Input::get('account_id');
	    $bill_no_of=Input::get('bill_no');
	    $amount_of=Input::get('amount');

	    $crf_no=Input::get('crf_no');
	    $bill_new_cust=Input::get('bill_new_cust');
	    $bill_new_dev=Input::get('bill_new_dev');

	    $plan_account_id = Input::get('plan_account_id');
	    $plan_bill_no = Input::get('plan_bill_no');
	    $plan_amount=Input::get('plan_amount');
	    $topup_bill_no = Input::get('topup_bill_no');


	   if(Input::get("customer_type")=="exiting_customers" || Input::get("customer_type")=="planchange_topup" ){
			    if(!empty($account_id_of)){
			    	$account_id[]=$account_id_of;
			    	$bill_no[]=$bill_no_of;
			    	$amount[]=$amount_of;
			    }else if(!empty($account_ids[0])){
			    	$account_id=$account_ids;
			    	$bill_no=$bill_nos;
			    	$amount=$amounts;
			    }
			}
	    if(Input::get("customer_type")=="new_customers"){
			    if(!empty($crf_no)){
			    		$account_id[]=$crf_no;
				    	$bill_no=$bill_new_cust;
				    	$amount[]=$amount_of;
			    }else if(!empty($account_ids_new[0])){
			    		$account_id=$account_ids_new;
				    	$bill_no=$bill_new_cust;
				    	$amount=$amounts_new;
			    }
			}
		if(Input::get("customer_type")=="device_details"){
				if(!empty($crf_no)){
			   		$account_id[]=$crf_no;
			   		$bill_no=$bill_new_dev;
			   		$amount[]=$amount_of;
			    }else if(!empty($account_ids_new[0])){
			    	$account_id=$account_ids_new;
			    	$bill_no=$bill_new_dev;
			    	$amount=$amounts_new;
			    }
			}

			if(!empty($crf_no)){
					$cust_det=CusDet::where('crf_no','=',$crf_no)->first();
				if($cust_det){
					$bill_det=Bill::where('account_id','=',$cust_det->account_id)->first();
					if($bill_det){
						return Redirect::back()
								->with('failure','Bill has been generated Payment Should Enter Via Exiting Customer Account ID '.$bill_det->account_id);
					}else{
						return Redirect::back()
								->with('failure','Account has been activated Payment Should Enter with  Account Id Via New Customer Account ID '.$cust_det->account_id);
					}
				}else{
					$exist_amount = PaymentTransaction::where('account_id',$crf_no)->where('amount',$amount)->where('payment_type','=','offline')->where('status','=','success')->get();
				}
			}

			if(!empty($crf_no)){
					$cust_det=CusDet::where('account_id','=',$crf_no)->first();
				if($cust_det){
					$bill_det=Bill::where('account_id','=',$cust_det->account_id)->first();
					if($bill_det){
						return Redirect::back()
								->with('failure','Bill has been generated Payment Should Enter Via Exiting Customer Account ID '.$bill_det->account_id);
					}else{
						$exist_amount = PaymentTransaction::where('account_id',$crf_no)->where('amount',$amount)->where('payment_type','=','offline')->where('status','=','success')->get();
					}
				}
			}
			$exist_amount = PaymentTransaction::where('account_id',$crf_no)->where('amount',$amount)->where('payment_type','=','offline')->where('status','=','success')->get();
			//var_dump($account_id,$bill_no,$amount);die;
		   for ($i=0; $i < count($account_id);$i++){
					$tran_code = substr( "ABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,25 ) ,1 ).substr($account_id[$i], -3) . substr($bill_no[$i], -3) . sprintf("%06s", count(PaymentTransaction::all()));

	            	$transactions = PaymentTransaction::where('transaction_code','=',$tran_code)->get();

	            	if(Input::get('bill_no')){
		            	$exist_amount_already = PaymentTransaction::whereIn('bill_no',$bill_no)->whereIn('amount',$amount)->where('payment_type','=','offline')->where('status','=','success')->get();
					}else{
						$exist_amount_already =NULL;
					}
				    if (count($transactions) != 0 || count($exist_amount) !=0 || count($exist_amount_already) !=0 ) {
				    	$transaction = $transactions->first();
				    	return Redirect::back()
								->with('failure','Amount Aleady Entered Duplicate Entery');
				    }

						    $transaction = new PaymentTransaction();
						    $transaction->bill_no =$bill_no[$i];	
							$transaction->account_id =$account_id[$i];
							$transaction->transaction_code = $tran_code;
							$transaction->amount =$amount[$i];
							$transaction->status = Input::get('transaction_type') == "cheque" ? "pending":"success";
							$transaction->remarks = Input::get('remarks');
							$transaction->transaction_type = Input::get('transaction_type');
							if($payment_date){
								$transaction->created_at = $payment_date;
							}
							$transaction->payment_type = 'offline';
		                    $transaction->save();


		                   if(!$payment_date){
			                   	if((Input::get('transaction_type') != "cheque")){
			                    	$this->UpdateBill($transaction->amount,$transaction->bill_no);
			                    	$this->UpdateActivation($transaction->account_id,$transaction->bill_no);
			                	}
			                }

			              if(Input::get("customer_type")=="planchange_topup" || Input::get("customer_type")=="exiting_customers" ){
		              			$this->Deleteplanchange($transaction->bill_no,$transaction->account_id);
		              			$this->DeleteTopup($transaction->bill_no,$transaction->account_id);
			                    $this->notifyUserSuccess($transaction);
			              }


						  if (Input::get('transaction_type') == "cheque") {
			                	$transaction_details = array($account_id,$bill_no,$amount);
								$cheque_transaction = new ChequeTransaction();
								$cheque_transaction->cheque_no = Input::get('cheque_no');
								$cheque_transaction->cheque_status = "pending";
								$cheque_transaction->status_updated_by = Auth::employee()->get()->name ;
								$cheque_transaction->transaction_details = json_encode($transaction_details);
								$cheque_transaction->transaction_id = $transaction->id;
								$cheque_transaction->cheque_holder_name = Input::get('cheque_holder_name');
								$cheque_transaction->cheque_account_no = Input::get('cheque_account_no');
								$cheque_transaction->ifsc_code = Input::get('ifsc_code');
								$cheque_transaction->save();
				            } 

						if (Input::get('transaction_type') == "card") {
			                	$transaction_details = array($account_id,$bill_no,$amount);
								$card_transaction = new CardTransaction();
								$card_transaction->transaction_details= json_encode($transaction_details);
								$card_transaction->transaction_id = $transaction->id;
								$card_transaction->terminal_id=Input::get('terminal_id');
								$card_transaction->merchant_id=Input::get('merchant_id');
								$card_transaction->invoice_id=Input::get('invoice_id');
								$card_transaction->card_last_four_digit=Input::get('card_last_four_digit');
								$card_transaction->save();
				            }
		     	}


			return Redirect::to('admin/payments/transactions')->with('success','Paid Successfully');

	}

	public function notifyUserSuccess($transaction){
		$cust=CusDet::where('account_id',$transaction->account_id)->first();
		if(count($cust)!=0){
			$params = array('email' => $cust->email,
		         'firstname' => $cust->firstname,
		         'phone' => $cust->phone );

			$transaction->sendSmsPaymentSuccess($params);
			$transaction->sendEmailPaymentSuccess($params);
		}
	}

	public function showCheque($id){
		$cheque = ChequeTransaction::where('transaction_id', '=',$id)->get()->first();
		$multi_cheque = ChequeTransaction::where('transaction_details', '=',$cheque->transaction_details)->get();
        
		foreach ($multi_cheque as $key => $cheque) {
		   $pay[] = PaymentTransaction::where('id', '=',$cheque->transaction_id)->get()->first();
		}

		$data['pay']=$pay;
		//var_dump($pay);die;
        
		if (!is_null($cheque)) {
			$data['cheque'] = $cheque;
			$data['multi_cheque'] = $multi_cheque;
			return View::make('admin.payments.show_cheque',$data);
		}
		return Redirect::route('admin.payments.cheque_list')
							->with('failure','Invalid Transaction ID');
	}

	public function updateCheque(){
		$id=Input::get('id');
		if (!is_null($id)) 
		{
			$update_cheque=ChequeTransaction::where('transaction_id','=',$id)->get()->first();
			$update=ChequeTransaction::where('transaction_details','=',$update_cheque->transaction_details)->get();
	        $status=Input::get('status');
	        $remarks=Input::get('remarks');
			foreach ($update as $value) {

				$value->cheque_status=$status;
				$value->status_updated_by = Auth::employee()->get()->name;
				$value->save();

				$payment=PaymentTransaction::where('id','=',$value->transaction_id)->get()->first();
				if($status=="cleared"){
					$payment->status="success";
				}else if($status=="deposited"){
					$payment->status="pending";	
				}else{
					$payment->status="failed";	
				}
				$payment->remarks=$remarks;
				$payment->save();

				if($status=="cleared"){
					$this->UpdateBill($payment->amount,$payment->bill_no);
				}else{
					DB::table('bill_det')->where('bill_no','=',$payment->bill_no)
							->update(array(
								'amount_paid' => 0,
								'status' => "not_paid"
							));
				}
		        
			}
			return Redirect::back()
								->with('success','updated successfully');
		}
	}
	

	public function resendNotification(){
		$transaction = PaymentTransaction::find(Input::get('transaction_id'));
		//var_dump($transaction);die;
		if (!is_null($transaction)) {
			$customer = CusDet::where('account_id','=',$transaction->account_id)->get()->first();

			if (!is_null($customer)) {
				$senderId = "OODOOP";

				if ($transaction->transaction_type == "cheque") {

					$message = "Your Payment of Rs.".$transaction->amount." for Account ID ".$transaction->account_id." is Received. Your transction id ". $transaction->transaction_code ." for your future reference. Amount will be credited to your oodoo account subjected to clearence of your Cheque. Contact support@oodoo.co.in or +91 8940808080 for more info.";	
				} else {

					$message = "Your Payment of Rs.".$transaction->amount." for Account ID ".$transaction->account_id." is Successful.\n Your transction id ". $transaction->transaction_code ." \n for your future reference. Contact support@oodoo.co.in or +91 8940808080 for more info.";

				}
				
			 	$mobileNumber = $customer->phone;		

				$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);

				$params = array('email' => $customer->email,
					         'firstname' => $customer->firstname,
					         'phone' => $customer->phone );

				$transaction->sendEmailPaymentSuccess($params);

				return Redirect::route('admin.payments.transactions.index')
							->with('success','Resent Notofication Successfully');
			}
			return Redirect::route('admin.payments.transactions.index')
							->with('failure','Invalid Customer in Transaction Record');
		}		
		return Redirect::route('admin.payments.transactions.index')
							->with('failure','Invalid Transaction ID');
	}

    public function fetchBillNo(){
		$account_id = Input::get('account_id');
		$bill_no = Bill::where('account_id','=',$account_id)->orderBy('bill_no', 'desc')->first();
		if(count($bill_no) != 0) {
			$response = array(
						'found' => "true",
						'bill_no' => $bill_no->bill_no,
						'amount' => $bill_no->amount_before_due_date-$bill_no->amount_paid,
						'account_id' => $bill_no->account_id,
					);
			return Response::json($response);
		}
		return Response::json(array('found' => "false"));
	}


	public function cardList(){
	   
		return View::make('admin.payments.card_list');	
	}

	public function cardAjax(){
		$card = CardTransaction::join('payment_transactions', 'card_transactions.transaction_id', '=', 'payment_transactions.id')
				                    ->select('card_transactions.id','card_transactions.merchant_id','card_transactions.terminal_id',
									'payment_transactions.account_id','card_transactions.card_last_four_digit','card_transactions.invoice_id',
									'payment_transactions.status')->orderBy('card_transactions.id','desc');
		 $card_list= Datatables::of($card)->make();
        
        return $card_list;

	}


	public function UpdateBill($amount,$bill_no){
		$bill=Bill::where('bill_no','=',$bill_no)->get()->first();
		if($bill && $bill_no!=300300){
		$amount_paid=(int)$bill->amount_paid + (int)$amount;
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

	public function UpdateActivation($account_id,$bill_no){
		$bills=Bill::where('account_id','=',$account_id)->get();
		if(count($bills)>=2){
			$bill=Bill::where('bill_no','=',$bill_no)->where('status','=','paid')->get()->first();
			$active_det=ActivationDetails::where('account_id','=',$account_id)->orderBy('expiry_date','desc')->get()->first();
			
			if($active_det && $bill){

				if($active_det->expiry_date < $bill->bill_end_date){
				 	CusDet::CreateActivationDetails($account_id,$bill->bill_end_date,$bill->amount_paid,$bill_no);
				}
		    }

			if(!$active_det && $bill){
			 	CusDet::CreateActivationDetails($account_id,$bill->bill_end_date,$bill->amount_paid,$bill_no);
			}

		}

	}



	public function edit($id){
		$data['payment']=PaymentTransaction::where('id','=',$id)->get()->first();
		$data['cheque']=ChequeTransaction::where('transaction_id','=',$id)->get()->first();
		$data['card']=CardTransaction::where('transaction_id','=',$id)->get()->first();
		if($data['payment']->status=="pending" || $data['payment']->status=="failed" || $data['payment']->status=="failure"){
			$data['re_transaction']=$data['payment']->transaction_code;
		}else{
			$data['re_transaction']=NULL;
		}
		return View::make('admin.payments.edit',$data);	
	}

	public function update(){
			$id=Input::get('id');
			$payment=PaymentTransaction::where('id','=',$id)->get()->first();
			$cheque=ChequeTransaction::where('transaction_id','=',$id)->get()->first();
			$card=CardTransaction::where('transaction_id','=',$id)->get()->first();
			
			$transaction_code=Input::get('transaction_code');


			if($transaction_code){
				$re_trans=PaymentTransaction::where('transaction_code','=',$transaction_code)->get()->first();
				
				if($re_trans->status == "failed" || $re_trans->status == "failure"){
					if(Input::get('status') == "pending" || Input::get('status') == "success"){
						$status=Input::get('status');
					}else{
						return Redirect::back()->with('failure','Invalid Status');
					}
				}else if($re_trans->status == "pending"){
					if(Input::get('status') == "success"){
						$status=Input::get('status');
					}else{
						return Redirect::back()->with('failure','Invalid Status');
					}
				}else if($re_trans->status == "success"){
					return Redirect::back()->with('failure','Invalid Status');
				}

				if(Input::get('status') != "success"){
					$re_trans->status=$status;
					$re_trans->save();
				}
				if(Input::get('status') == "success"){
					$bill_up=Bill::where('account_id',$re_trans->account_id)->where('bill_no','>',$re_trans->bill_no)->orderBy('bill_no','asc')->get();
					$bill=Bill::where('account_id',$re_trans->account_id)->where('bill_no',$re_trans->bill_no)->first();
					$this->UpdateBill($re_trans->amount,$re_trans->bill_no);
					foreach ($bill_up as $key) {
						$plan=Plan::where('account_id',$key->account_id)->first();
						$billchange=PlanChangeDetail::billChange($key->bill_no,$plan->plan_code,$key->current_rentel);
						if(count($billchange)==2){
							if($billchange['status']=='false'){
								DB::table('bill_det')->where('bill_no','=',$bill->bill_no)->update(array('amount_paid' =>0,'status' => "not_paid"));
								return Redirect::back()->with('failure',$billchange['name'].' amount not matched with bill');
							}
						}
					}

					$re_trans->status=$status;
					$re_trans->save();

					$cust_det=CusDet::where('account_id',$re_trans->account_id)->first();
					$this->UpdateActivation($re_trans->account_id,$re_trans->bill_no);
					
					if($cust_det){
						$params = array('email' => $cust_det->email,
					         'firstname' => $cust_det->firstname,
					         'phone' => $cust_det->phone );
				
						$re_trans->sendSmsPaymentSuccess($params);
						$re_trans->sendEmailPaymentSuccess($params);
					}
					
					$planChange=PlanChangeDetail::where('bill_no',$re_trans->bill_no)->first();
					$topup_det=TopupDetail::where('bill_no',$re_trans->bill_no)->first();
					
					if($planChange){
		              		$this->Deleteplanchange($re_trans->bill_no,$re_trans->account_id);
			            }

			        if($topup_det){
		              		$this->DeleteTopup($re_trans->bill_no,$re_trans->account_id);
			            }
			    }

			}
			
			if($payment){
				$payment->bill_no=Input::get('bill_no');
				$payment->account_id=Input::get('account_id');
				$payment->amount=Input::get('amount');
				$payment->created_at=Input::get('payment_date');
				$payment->remarks=Input::get('remarks');
				$payment->save();
			}
			if($card){
				$card->terminal_id=Input::get('terminal_id');
				$card->merchant_id=Input::get('merchant_id');
				$card->invoice_id=Input::get('invoice_id');
				$card->card_last_four_digit=Input::get('card_last_four_digit');
				$card->save();
			}
			if($cheque){
				$cheque->cheque_no = Input::get('cheque_no');
				$cheque->cheque_holder_name = Input::get('cheque_holder_name');
				$cheque->cheque_account_no = Input::get('cheque_account_no');
				$cheque->ifsc_code = Input::get('ifsc_code');
				$cheque->save();
			}
			return Redirect::to('admin/payments/transactions')
						->with('success','Updated Successfully');	
	}


	public function userPayment(){
		$account_id=Input::get('account_id');
		$payment= DB::table('payment_transactions')
						->select('created_at','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','payment_type',
								'status')->where('account_id','=',$account_id)->orderBy('bill_no','desc');
        if($payment){
        $payment_user = Datatables::of($payment)->addColumn('operations','<button type="button" class="btn btn-minier btn-primary" onclick="payment({{$bill_no}})" >
								                                            view
								                                            </button>'
        																,false)->make();

        	return $payment_user;
    	}else{
    		return null;
    	}
	}

	private function Deleteplanchange($bill_no,$account_id){
		$status=PlanChangeDet::where('account_id',$account_id)->where('status','payment pending')->first();
		if($status){
			$status->status="pending";
			$status->save();
			$planChange=PlanChangeDetail::where('bill_no',$bill_no)->delete();
		}
	}

	private function DeleteTopup($bill_no,$account_id){
		$status=TopupDet::where('account_id',$account_id)->where('status','payment pending')->first();
		if($status){
			$status->status="pending";
			$status->save();
			$topup_det=TopupDetail::where('bill_no',$bill_no)->delete();
		}
	}

}