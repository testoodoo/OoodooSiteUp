<?php

class CusDet extends \LaravelBook\Ardent\Ardent {


	protected $table = 'cust_det';

	public static $rules = array(
        'email' => 'required|email|min:6',
        'phone' => 'required|digits:10',
        'pincode'       => 'required|digits:6',
        'address1' => 'required',
        'dob' => 'required',
        'gender' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'title' => 'required',
    );


	public function plan(){
		$plans = Plan::where('account_id','=',$this->account_id)->get();
		if (count($plans) != 0) {
			return $plans->first();
		} 
		return null;
	    }

	public function employee(){
		$employee =DB::table('employees')->get();
		if (count($employee) != 0) {
			return $employee;
		} 
		return null;
	    }

	public function bills(){
		$bills=Bill::where('account_id','=',$this->account_id)->get();
		if(count($bills) != 0){
		return $bills;
		}
		return null;
	    }


	public function transactions(){
		$payments=PaymentTransaction::where('account_id','=',$this->account_id)->get();
		if(count($payments) != 0){
			return $payments;
		}
		return null;
	    }
	public function datausages(){
		$usages=DataUsage::where('account_id','=',$this->account_id)->get()->first();
		if(count($usages) != 0){
			return $usages;
		}
		return null; 
	    }

	public function tickets(){
		$tickets=Ticket::where('mobile','=',$this->mobile)->orderBy('id','desc')->get();
		if(count($tickets) != 0){
			return $tickets;
	    }
	    return null; 
	    }

	public function assigned_emp($assigned_to){
			return Employee::where('employee_identity',$assigned_to)->first();
	}

	public function userticket(){
		$userticket=Ticket::where('account_id','=',$this->account_id)->orderBy('id','desc')->get();
		if(count($userticket) != 0){
			return $userticket;
	    }
		return null; 
	    }


	public function city(){
		$Masterdata=Masterdata::where('type','=','city')->get();
		if(count($Masterdata) != 0){
			return $Masterdata;
	    }
	    return null; 
	    }


	public function ticket_type(){
		$md = Masterdata::where('type','=','Complaint')->get();
		if(count($md) != 0){
			return $md;
	   }
	    return null; 
	    }

	public function datausagesmh(){
		$datausagesmh=DataUsageMh::where('account_id','=',$this->account_id)->orderBy('srl','desc')->get();
		if(count($datausagesmh) != 0){
		return $datausagesmh;
	    }
	     return null; 
	    }

	public function status($status_id){
		$s =  Masterdata::where('id','=',$status_id)->get()->first();
			return $s;
	    }

	

	public function jsubs($account_id){
		$jsubs =  Jsubs::where('account_id','=',$account_id)->get()->first();
			return $jsubs;
	    }

	public function getOwnStatus(){
		return $this->belongsTo('Masterdata', 'status_id');	
	    }

	public function owner(){
		$name = Employee::find($this->owner_id);
			return $name; 
	 }

	public function employee_identity(){
			$name=Employee::all();
			if($name){
			return $name;
		}
		return NULL;
	}

	public function statuslist(){
		$statuslist=Masterdata::where('type','=','ticket_status')->get();
		return $statuslist;
	}

	public function feasible(){
			$crf_no=CusDet::where('account_id','=',$this->account_id)->get()->first();
		if($crf_no){
			$feasiable=PreActivationStatus::where('crf_no','=',$crf_no->crf_no)->get()->first();
		return $feasiable;
	    }
	    return null;
	}

	static public function CreateActivationDetails($account_id,$expiry_date,$amount_paid,$bill_no){

		$activation=new ActivationDetails();
		$activation->account_id =$account_id;
		$activation->bill_no =$bill_no;
		$activation->status="approved";
		$activation->expiry_date=$expiry_date." 23:59:59";
		$activation->request_id =444444;
		$activation->remarks ="amount_paid :".$amount_paid;
		$activation->save();

		return $activation;

	}


}
