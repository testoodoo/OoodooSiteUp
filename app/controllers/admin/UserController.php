<?php
namespace Admin;
use View,PlanCostDetail,ActiveCustomer,Input,Redirect,NewCustomer,CustomerStatus,Employee,Auth,Masterdata,DB;
use CustomerApplicationStatus, Ticket, Stattus,FileUpload,DocumentMapping,Bill,PaymentTransaction,JAccountDetail;
use NewCustomerDetail, PreActivationStatus, Session,Validator,App,Response;

class UserController extends \BaseController {


    public function getRegistration() {
		$data['employees'] = Employee::all();

		$data['plans'] = PlanCostDetail::all();
		$area = MasterData::where('type','=','area')->get();
		$city = MasterData::where('type','=','city')->get();
		$status_data = MasterData::where('type','=','new_customer_application_status')->get();
        $data['status_data']=$status_data;
        $data['area']=$area;
        $data['cities']=$city;
        return View::make('admin.new_customers.registration',$data);
	}


		
	public function postRegistration() {
		$title = empty(Input::get('title')) ? Input::get('other_title') : Input::get('title');

		$newCustomer = new NewCustomer();
        $newCustomer->created_by_employee_id  	= Auth::employee()->get()->employee_identity;
        $newCustomer->sales_employee_id    		= Input::get('sales_employee_id');
        $newCustomer->title              		= $title;
        $newCustomer->first_name              	= Input::get('first_name');
        $newCustomer->last_name              	= Input::get('last_name');
        $newCustomer->email              		= Input::get('email');
        $newCustomer->address1              	= Input::get('address1');
        $newCustomer->address2              	= Input::get('address2');
        $newCustomer->address3              	= Input::get('address3');
        $newCustomer->city               		= Input::get('city');
        $newCustomer->phone              		= Input::get('phone');
        $newCustomer->pincode            		= Input::get('pincode');
        $newCustomer->state              		= Input::get('state');
        $newCustomer->dob                		= Input::get('dob');
        $newCustomer->plan_code          		= Input::get('plan_code');
        $newCustomer->gender             		= Input::get('gender');
        $newCustomer->application_date      	= Input::get('application_date');
        $newCustomer->application_no      		= Input::get('application_no');
        $newCustomer->request_id 				= NewCustomer::generateRandomNumber();
        $substr_app_no=substr(Input::get('application_no'),0,6);
        if ('OFAFAA'==$substr_app_no && strlen(Input::get('application_no'))==12) {
        	 if (Input::get('application_date') <= date('Y-m-d')) {
			        $new_customer_validation = Validator::make(Input::all(), NewCustomer::rules('create', [], $newCustomer->id));

							if ($new_customer_validation->fails()) {
							    return Redirect::back()
											->withErrors($new_customer_validation->messages())
											->withInput();
							}
					        if($newCustomer->save()) {
					        	//insert into new customer Detail
					        	NewCustomerDetail::create(
					        			array('crf_no' => $newCustomer->application_no, 'status' => 'Processing' )
					        			);
					        	//insert into pre activation status
					        	PreActivationStatus::create(array('crf_no' => $newCustomer->application_no));
					        	//send sms...	
								$senderId = "OODOOP";
								$mobileNumber =$newCustomer->phone;
								$message="Your Application ".$newCustomer->request_id." is successfully processed and will be completed within 10 working days. Please contact support @ 8940808080 for more updates";
								
								$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message);

					        	return Redirect::route('admin.users.list')
					       				->with('success','Succesfully Created');
					       	} else {
					       		return Redirect::back()
											->withErrors($newCustomer->errors())
											->withInput();
					       	}
				}else{
					return Redirect::back()
        			->with('failure','Invalid Application Date');
				}
        	}else{
        		return Redirect::back()
        		->with('failure','Invalid Application No.Should Enter With OFAFAA');
        }
    }
    public function newCustomerList() {
       $data['area']=Masterdata::where('type','=','area')->get();
       $data['employees']=Employee::all();
       return View::make('admin.new_customers.list',$data);
    }

    public function newCustomerPrint() {
       $data['employees']=Employee::all();
       $data['area']=Masterdata::where('type','=','area')->get();
       return View::make('admin.new_customers.new_customers_print',$data);
	}


	public function edit($id){

		if(Input::get('activation_process') == 'true'){
			Session::put('activation_process','true');
		}
		$new_customer = NewCustomer::find($id);

		if(is_null($new_customer)){
			return Redirect::route('admin.users.list')
					->with('failure','Invalid ID');
		}

		$data['new_customer'] = $new_customer;
		$data['employees'] = Employee::all();

		return View::make('admin.new_customers.edit',$data);
	}

	public function update(){
		$new_customer = NewCustomer::find(Input::get('customer_id'));

		if(is_null($new_customer)){
			return Redirect::route('admin.users.list')
					->with('failure','Invalid ID');
		}

		//do the Update Action

		$title = empty(Input::get('title')) ? Input::get('other_title') : Input::get('title');
        $new_customer->created_by_employee_id  	= Auth::employee()->get()->employee_identity;
		$new_customer->sales_employee_id    	= Input::get('sales_employee_id');
		$new_customer->title              		= $title;
		$new_customer->first_name              	= Input::get('first_name');
		$new_customer->last_name              	= Input::get('last_name');
		$new_customer->email              		= Input::get('email');
		$new_customer->address1              	= Input::get('address1');
		$new_customer->address2              	= Input::get('address2');
		$new_customer->address3              	= Input::get('address3');
		$new_customer->city               		= Input::get('city');
		$new_customer->phone              		= Input::get('phone');
		$new_customer->pincode            		= Input::get('pincode');
		$new_customer->state              		= Input::get('state');
		$new_customer->dob                		= Input::get('dob');
		$new_customer->plan_code          		= Input::get('plan_code');
		$new_customer->gender             		= Input::get('gender');


		$new_customer_validation = Validator::make(Input::all(), NewCustomer::rules('update', [], $new_customer->id));

		if ($new_customer_validation->fails()) {
		    return Redirect::back()
						->withErrors($new_customer_validation->messages())
						->withInput();
		}

        $new_customer->save();

		if(!is_null(Session::get('activation_process'))){
			Session::forget('activation_process');
			return Redirect::route('admin.users.customer_activation_process',array('id' => $new_customer->id));
		}

		return Redirect::route('admin.users.list')
			->with('success','Updated Succesfully');

		return View::make('admin.users.edit',$data);
	}

	public function statusUpdate(){
		$application_no = Input::get('customer_id');
		$status = Input::get('status');
		$new_customer = NewCustomer::where('application_no',$application_no)->first();

		if(is_null($new_customer)){
			return Redirect::route('admin.users.list')
					->with('failure','Invalid ID');
		}

		$new_customer_detail = PreActivationStatus::where('crf_no','=',$application_no)
								->get()->first();

		if(!is_null($new_customer_detail)){
			$new_customer_detail->activation = Input::get('status');
			$new_customer_detail->save();
			$status_up=$status == 1 ? "success" : "failed";
			$response= array('found' => "true",
				'status'=>$status,
				);
			
			return Response::json($response);
		} else {
			return Redirect::back()->with('failure','Record Not Found in new_customers_details table');
		}
	}

    public function preActivationShow($id){
    	$data['customer'] = NewCustomer::where('application_no',$id)->first();
    	$customer = NewCustomer::where('application_no',$id)->first();
    	if(!is_null($customer)){
		$data['document_types'] = Masterdata::where('type','=','document_type')->get();
		$data['employees'] = Employee::all();
		$data['area'] = Masterdata::where('type','=','area')->get();
        $data['new_customers'] = NewCustomer::all();

		$data['preactivation_status'] = PreActivationStatus::where('crf_no','=',$customer->application_no)->get()->first();
        $closed_status = Masterdata::getId('Closed','ticket_status');
		$ticket_type_id = Masterdata::getId('new_customer_pre_activation','ticket_type');
		$data['ticket_type'] = Masterdata::where('type','=','customer_activation_process')->get();
		$data['ticket'] = Ticket::where('crf_no','=',$customer->application_no)->get()->first();
		$data['ticket_status_list'] = Masterdata::where('type','=','ticket_status')->get();
	    $data['ticket_type_id'] = $ticket_type_id;

	    $document = DocumentMapping::where('owner_id','=',$customer->id)->get()->first();
	    if(count($document)!=0)	{
			$data['photo_view']=FileUpload::where('id','=',$document->id)->where('document_id','=','14')->get()->first();
			$application=str_replace('/uploads/','/applications/',$data['photo_view']->file_name);
			$data['app_view']='/uploads'.$application;
	  	}else {
		    $data['photo_view'] = NULL;	
		    $data['app_view']=NULL;
		}

		return View::make('admin.new_customers.pre_activation_show',$data);
	    }
		return Redirect::route('admin.users.list')
	       				->with('failure','Invalid ID');
	}



	public function preActivationPost(){
		$customer = NewCustomer::where('application_no',Input::get('customer_id'))->first();
		//var_dump($customer);die;
		if(!is_null($customer)) {

			$pas = PreActivationStatus::where('crf_no',Input::get('preactivation_status_id'))->first();

			$pas->feasible = Input::get('feasible');

			$pas->fiber = 0;
			$pas->splicing = 0;
			$pas->hut_boxes = 0;
			$pas->ethernet = 0;
			$pas->activation = 0;
			$pas->configuration = 0;
			

			if(Input::get('fiber')) {
				$pas->fiber = 1;
				$pas->fiber_updated_at = date('Y-m-d H:m:s');
			}

			if(Input::get('splicing')) {
				$pas->splicing = 1;
				$pas->splicing_updated_at = date('Y-m-d H:m:s');
			}

			if(Input::get('hut_boxes')) {
				$pas->hut_boxes = 1;
				$pas->hut_boxes_updated_at = date('Y-m-d H:m:s');
			}

			if(Input::get('ethernet')) {
				$pas->ethernet = 1;
				$pas->ethernet_updated_at = date('Y-m-d H:m:s');
			}

			if(Input::get('activation')) {
				$pas->activation = 1;
				$pas->activation_updated_at = date('Y-m-d H:m:s');
			}

			if(Input::get('configuration')) {
				$pas->configuration = 1;
				$pas->configuration_updated_at = date('Y-m-d H:m:s');
			}
			$pas->save();

			if(!$pas->feasible) {
				$pas->fiber = 0;
				$pas->splicing = 0;
				$pas->hut_boxes = 0;
				$pas->ethernet = 0;
				$pas->activation = 0;
				$pas->configuration = 0;
				$pas->save();
			}

			$customer->remarks=Input::get('remarks');
			$customer->save();

			return Redirect::route('admin.users.pre-activation-show',array('id' => $customer->application_no))
       				->with('success','Updated Succesfully');	

		}
		return Redirect::route('admin.users.pre-activation-show')
       				->with('failure','Invalid ID');
	}


	
	public function customerActivation()	{
       return View::make('admin.new_customers.get_activation');
	}


	
	public function fetchCustomer()  	{
		$request_id = Input::get('request_id');
		$application_no = Input::get('application_no');

		//check with application number first
		$new_customer = NewCustomer::where('application_no','=',$application_no)->get()->first();
		if(is_null($new_customer)){

			//or else check with request ID then
			$new_customer = NewCustomer::where('request_id','=',$request_id)->get()->first();			
		}
		if(!is_null($new_customer)){
			return Redirect::route('admin.users.customer_activation_process',array('id' => $new_customer->id));
					
		} else {
			return Redirect::route('admin.users.customer_activation')
					->with('failure','Customer Not Found');
		}
	}


	
	public function customerActivationProcess($id)	{
		$data['new_customer'] = NewCustomer::find($id);
		if(is_null($data['new_customer'])){
			return Redirect::route('admin.users.list')
					->with('failure','Invalid ID');
		}
		return View::make('admin.new_customers.customer_activation_process',$data);	
   	}

   	public function activate(){
   		$new_customer = NewCustomer::find(Input::get('customer_id'));
		if(!is_null($new_customer)){
			$data['new_customer'] = $new_customer;
			$data['remarks'] = Input::get('remark');
			$data['plan_start_date'] = Input::get('plan_start_date');
			return View::make('admin.new_customers.activation',$data);

		}
   	}

 
	public function preActivationTicketPopup($id) {
        $closed_status = Masterdata::getId('Closed','ticket_status');
		$ticket_type_id = Masterdata::getId('new_customer_pre_activation','ticket_type');
		$new = NewCustomer::where('id','=',$id)->get()->first();
		if($new){
			$data['ticket'] = Ticket::where('crf_no',$new->application_no)->first();
		}else{
			$data['ticket'] =NULL;
		}
		$data['ticket_status_list'] = Masterdata::where('type','=','ticket_status')->get();
	    $data['ticket_type_id'] = $ticket_type_id;
		
		return View::make('admin.new_customers.ticket_history_popup',$data);
		
	}



//java script activation ........for plan cost details...
    public function planSubscripe()
	{
		 
	       $role=PlanCostDetail::all();
	         if($role)
	        {
	            foreach ($role as $row)
	          {
				$months = $row['number_of_months'];
				$Subs = $row['subs'];
				$subs[$months] = $Subs;
			  }								
				$subs['0'] = 'Subscription';
	            echo json_encode($subs);
	        }
	}
	
	public function planDetail()
	{
		    $type=Input::get('type');	    
		    $months=Input::get('subs');
			$role=PlanCostDetail::where('plan_group','=',$type)
			                      ->where('number_of_months','=',$months)->get();
			if($role)
			{
                foreach ($role as $row)
              {
				$plan_code = $row['plan_code'];
				$plan_desc = $row['plan_desc'];
				$plans[$plan_code] = $plan_desc;
			  }								
				$plans['0'] = "Plans";								
				echo json_encode($plans);
			}
	}

}
