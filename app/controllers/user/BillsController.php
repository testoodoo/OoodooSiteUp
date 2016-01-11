<?php
namespace User;
use BaseController, Auth, Bill, Session, View, Redirect, round, PDF, Input,User, DB;
use \Illuminate\Config\Repository;

class BillsController extends BaseController {

	protected $layout = 'user._layouts.default';

	public function index(){
		$account_id = Auth::user()->get()->account_id;
		$data['bills'] = Bill::where('account_id','=',$account_id)
							->orderBy('bill_no', 'desc')
							->paginate(10);
		return View::make('user.bills.index',$data);
	}

	public function payBill(){
		$account_id = Auth::user()->get()->account_id;
		$bill_no = Bill::orderBy('bill_no','desc')
						->where('account_id','=',$account_id)->get()->first()->bill_no;	
		$payable_amount = Auth::user()->get()->payableAmount();
		return Redirect::to('payment/payment_confirm')
			->with('bill_no', $bill_no)
			->with('payable_amount', $payable_amount);	

	}

	public function view($bill_no){
		$bills = Bill::where('bill_no','=',$bill_no)->get();
		if (count($bills)!=0) {
			$bill = $bills->first();
			$user = User::where('account_id','=',$bill->account_id)->get();
			if (count($user) != 0) {
				$user = $user->first();
				if (Auth::user()->get()->id == $user->id) {
					$data['user'] = $user;
					$data['bill'] = $bill;

					if (Input::get('download') == "true") {
						$pdf = PDF::loadView('user.bills.view',$data);
						return $pdf->download('oodoo_bill_'.$user->account_id.'-'.$bill->bill_no.'.pdf');
					} 
					return View::make('user.bills.view',$data);	
				}
			}
		}
		return "Invalid Request";
	}

}