<?php
class NewCustomer extends Eloquent {

	protected $table = 'new_customers';



	public function plan_type(){
		return PlanCostDetail::where('plan_code','=',$this->plan_code)->get()->first();
	}

    public static $rules = array(
        'create' => array(
            'application_no' => 'required|unique:new_customers,application_no',
            'email' => 'required|email|min:6',
            'phone' => 'required|digits:10',
            'pincode'       => 'required|digits:6',
            'address1' => 'required',
            'address2' => 'required',
            'address3' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'sales_employee_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'title' => 'required'
        ),
        'update' => array(
            'email' => 'required|email|min:6',
            'phone' => 'required|digits:10',
            'pincode'       => 'required|digits:6',
            'address1' => 'required',
            'address2' => 'required',
            'address3' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'sales_employee_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ),

    );

    public static function rules( $action, $merge=[], $id=false) {
        $rules = SELF::$rules[$action];

        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace(':id', $id, $rule);
            }
        }

        return array_merge( $rules, $merge );
    }

	public function insertStatus($newCustomer){

		$status_data = Masterdata::where('type','=','customer_activation_process')->get();
		     
		foreach ($status_data as $key => $status) {
	        $new_cust_status  = new CustomerApplicationStatus;
	        $new_cust_status->status_id = $status->id;
	        $new_cust_status->customer_id = $this->id; 
	        $new_cust_status->done = 0;
	        $new_cust_status->save();
		   } 
    }

    public function getCreatedByEmployee(){
    	return Employee::where('employee_identity','=',$this->created_by_employee_id)->get()->first();
    }


    public function documents(){
    	return DocumentMapping::where('owner_type','=','new_customer')
    					->where('owner_id','=',$this->id)->get();
    }

    public function app_document(){
    	$md_id = Masterdata::getId("OFAPL","document_type");
    	$document_mapping =  DocumentMapping::where('owner_type','=','new_customer')
    					->where('owner_id','=',$this->id)->get();	
    	if(count($document_mapping) != 0){
    		foreach($document_mapping as $dm){
    			if($dm->document->document_id == $md_id){
    				return $dm->document;
    			}
    		}
    	}
    	return false;
    }

    public function photo_document(){
    	$md_id = Masterdata::getId("OFPHO","document_type");
    	$document_mapping =  DocumentMapping::where('owner_type','=','new_customer')
    					->where('owner_id','=',$this->id)->get();	
    	if(count($document_mapping) != 0){
    		foreach($document_mapping as $dm){
    			if($dm->document->document_id == $md_id){
    				return $dm->document;
    			}
    		}
    	}
    	return false;
    }
    

    public static function generateRandomNumber() {
        $m = microtime(true);
        $random = $m*10000;
        $randomNumber = substr($random,2);
        return $randomNumber;
    }

    public function postStatus(){
        return PreActivationStatus::where('crf_no','=',$this->application_no)
                                ->get()->first();

    }
    function transactions(){
        $payment=PaymentTransaction::where('account_id','=',$this->application_no)->get();
        if(!empty($payment))
        {
        return $payment;
        }
       return null;

    }


    public function city(){
        return Masterdata::where('type','=','city')->get();
        }
        
    public function ticket_type(){
        $md = Masterdata::where('type','=','customer_activation_process')->get();
            return $md;
       }


    static function CheckCustomerDet($search,$query){
        
        $cust_det=DB::table('cust_det')->get();
        if($cust_det){
                foreach ($cust_det as $key) {
                    $crf_nos[]=$key->crf_no;
                }
            }
            if(count($search)!=0){
                 foreach ($search as $key) {
                    $crf_no[]=$key->application_no;
                }
            }else{
               $crf_no=NULL; 
            }
            if(count($query)!=0){
                $new_customers= DB::table('new_customers')
                        ->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
                        ->whereNotIn('new_customers.application_no',$crf_nos)
                        ->whereIn('new_customers.application_no',$crf_no)
                        ->where('pre_activation_status.activation','=',0)
                        ->orderBy('new_customers.id', 'desc')->get();
            }else{
                $new_customers= DB::table('new_customers')
                        ->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
                        ->whereNotIn('new_customers.application_no',$crf_nos)
                        ->where('pre_activation_status.activation','=',0)
                        ->orderBy('new_customers.id', 'desc')->get();
                    }
            return $new_customers;
       }

    static function CheckCustomerDetWithDate($feasible,$area,$from_date,$to_date,$assign_employee){
        
        $cust_det=DB::table('cust_det')->get();
        if($cust_det){
                foreach ($cust_det as $key) {
                    $crf_nos[]=$key->crf_no;
                }
            }
        if($area[0]=="all"){
                    $customers = DB::table('new_customers')
                                ->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
                                ->whereNotIn('new_customers.application_no',$crf_nos)
                                ->where('pre_activation_status.activation',0)
                                ->whereBetween('new_customers.application_date',[$from_date,$to_date])
                                ->get();
            }else if($assign_employee){
                $customers =  DB::table('new_customers')
                                ->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
                                ->whereNotIn('new_customers.application_no',$crf_nos)
                                ->where('pre_activation_status.activation',0)
                                ->whereBetween('new_customers.application_date',[$from_date,$to_date])
                                ->where('new_customers.assign_employee','=',$assign_employee)
                                ->get();
            }else{
                $customers =  DB::table('new_customers')
                                ->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
                                ->whereNotIn('new_customers.application_no',$crf_nos)
                                ->where('pre_activation_status.activation',0)
                                ->whereBetween('new_customers.application_date',[$from_date,$to_date])
                                ->whereIn('new_customers.address3',$area)
                                ->get();
                }
            if(count($customers)!=0){
                        foreach ($customers as $key) {
                            $crf[]=$key->application_no;
                        }
                }else{
                    $crf=NULL;
                }
            if($feasible){
                $pre_activation=NewCustomer::CheckPreActivation($feasible,$crf);
            }else{
                $pre_activation=$crf;   
            }
        return $pre_activation;

       }

   public static function CheckPreActivation($feasible,$crf){

            if($feasible == "splicing"){
                $pre_activation=PreActivationStatus::whereIn('crf_no',$crf)->where("$feasible",'=',0)->where('fiber','=',1)->where('activation','=',0)->get();
            }else if($feasible == "ethernet"){
                $pre_activation=PreActivationStatus::whereIn('crf_no',$crf)->where("$feasible",'=',0)->where('fiber','=',1)->where('splicing','=',1)->where('activation','=',0)->get();
            }else if($feasible == "configuration"){
                $pre_activation=PreActivationStatus::whereIn('crf_no',$crf)->where("$feasible",'=',0)->where('fiber','=',1)->where('splicing','=',1)->where('ethernet','=',1)->where('activation','=',0)->get();
            }else{
                $pre_activation=PreActivationStatus::whereIn('crf_no',$crf)->where("$feasible",'=',0)->where('activation','=',0)->get();
            }
            if(count($pre_activation)!=0){
                        foreach ($pre_activation as $key) {
                            $crf_no[]=$key->crf_no;
                            }
                        }else{
                            $crf_no=NULL;
                        }
        return $crf_no;

       }

}