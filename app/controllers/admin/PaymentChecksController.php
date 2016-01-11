<?php

namespace Admin;

use View,Role,Bill,Input,DB,Redirect,PaymentTransaction,Paginator,ChequeTransaction,Datatables,Response;

class PaymentChecksController extends \BaseController {


	public function BillPaymentCheck(){
		return View::make('admin.checks.bill_payment_checks');
	}

	public function BillPaymentCheckAjax(){

		$bills=DB::table('bill_det')->leftJoin('payment_transactions', 'bill_det.bill_no', '=', 'payment_transactions.bill_no')
		 							->select('bill_det.bill_no','bill_det.account_id','bill_det.bill_date','bill_det.amount_paid',
		 							'payment_transactions.transaction_code',DB::raw('sum(payment_transactions.amount) as amount'))
		 							->where('payment_transactions.status','=','success')
		 							->groupBy('bill_det.bill_no')
		 							->havingRaw('sum(bill_det.amount_paid) != sum(floor(payment_transactions.amount))')
		 							->orderBy('bill_det.bill_no','desc')->get();
		
		 foreach ($bills as $key => $value) {
		 	if($value->amount!=$value->amount_paid){
		 		$bill_no[]=$value->bill_no;
		 	}
		 }

		 $bill=DB::table('bill_det')->leftJoin('payment_transactions', 'bill_det.bill_no', '=', 'payment_transactions.bill_no')
		 							->select('bill_det.bill_no','bill_det.account_id','bill_det.bill_date','bill_det.amount_paid',
		 							'payment_transactions.transaction_code',DB::raw('sum(payment_transactions.amount) as amount'))
		 							->where('payment_transactions.status','=','success')
		 							->groupBy('bill_det.bill_no')
		 							->whereIn('bill_det.bill_no',$bill_no)
		 							->orderBy('bill_det.bill_no','desc');
		/*$bill=DB::table(DB::raw( 'SELECT a.bill_no, a.account_id, a.bill_date, a.amount_paid,
				 					b.transaction_code,b.amount from  bill_det a left join
									(select bill_no, transaction_code, sum(amount) as amount from payment_transactions 
									where status = "success" group by bill_no ) b
									on a.bill_no = b.bill_no where a.amount_paid != b.amount order by b.bill_no'));*/
		if($bill){
				$bill_det = Datatables::of($bill)->make();
			return $bill_det;
		}
	}

	public function PaymentCheck(){

		return View::make('admin.checks.transaction_checks');
	}

	public function BillCheck(){

		return View::make('admin.checks.bill_checks');
	}

	public function BillCheckAjax(){

		$transactions=DB::table('payment_transactions')->select('bill_no')->get();
		foreach ($transactions as $key) {
			$bill_no[]=$key->bill_no;
		}
		$bills=DB::table('bill_det')->select('bill_no','account_id','for_month','cust_current_plan',
							'bill_date','due_date','prev_bal','last_payment','adjustments','current_rental',
							'amount_before_due_date','amount_after_due_date','amount_paid','status')
						->whereNotIn('bill_no',$bill_no)->whereNotIn('amount_paid',[0])->orderBy('bill_no','desc');

		 $active_det = Datatables::of($bills)->make();

         return $active_det;
	}

	public function PaymentCheckAjax(){

		$bill_amount_paid=DB::table('bill_det')->select('bill_no')->get();
		foreach ($bill_amount_paid as $key) {
			$bill_no[]=$key->bill_no;
		}
		$transactions=DB::table('payment_transactions')->select('id','account_id','bill_no',
								'amount','transaction_code','transaction_type',
								'remarks','created_at','payment_type',
								'status')->whereNotIn('bill_no',$bill_no)
								->whereIn('status',['success'])->orderBy('id','desc');
		
		$active_det = Datatables::of($transactions)->make();

        return $active_det;
		

	}

	public function NotPaidActive(){
		return View::make('admin.checks.not_paid_active');
	}

	public function NotPaidActiveAjax(){

		$active=DB::table('not_paid_activations')->select('bill_no','account_id','for_month','amount_before_due_date',
 		 									'amount_paid','status','payment_amount','cust_status')
		 								->orderBy('bill_no','desc');

         $active_det = Datatables::of($active)->make();

         return $active_det;
		
	}



}
