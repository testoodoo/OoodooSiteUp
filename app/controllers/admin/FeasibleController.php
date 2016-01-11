<?php
namespace Admin;
use View,PlanCostDetail,ActiveCustomer,Input,Redirect,NewCustomer,CustomerStatus,Employee,Auth,Masterdata,DB;
use CustomerApplicationStatus, Ticket, Stattus,FileUpload,DocumentMapping,Bill,PaymentTransaction,JAccountDetail;
use NewCustomerDetail, PreActivationStatus, Session,Validator,App,Response,Datatables,CusDet;

class FeasibleController extends \BaseController {
	
	public function NewCustomerReject(){
		$data['employees']=Employee::all();
   		$data['area']=Masterdata::where('type','=','area')->get();
       return View::make('admin.new_customers.new_cust_reject',$data);
   	}
   	
   	public function NewCustomerAssign()
	{
	    $data['employees']=Employee::all();
   		$data['area']=Masterdata::where('type','=','area')->get();
       return View::make('admin.new_customers.assign_feasible',$data);
	}
	
	public function NewCustomerAssignAjax(){
		$feasible=Input::get('feasible');
		$area=Input::get('area');
		$from = Input::get('from');
		$to = Input::get('to');
		$print=Input::get('print');
		if(Input::get('print')=="print"){
			$areas=$area;
		}else{
			$areas=explode(',',$area);
		}
		if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
			$to_date = date("Y-m-d H:i:s");
			$from_date = date("Y-m-d H:i:s",strtotime("-2 month",strtotime($to_date)));
		}else{
			$from_date = date("Y-m-d H:i:s",strtotime($from));
			$to_date = date("Y-m-d H:i:s",strtotime($to));
		}
				if(count($area)!=0){
					$data['customers']=NewCustomer::CheckCustomerDetWithDate($feasible,$areas,$from_date,$to_date,NULL);
					$customers=$data['customers'];
					$data['custom']=DB::table('new_customers')->whereIn('application_no',$customers)->get();
				}else{
					$search=NULL;
					$data['customers'] =NewCustomer::CheckCustomerDet($search,NULL);
		            foreach ($data['customers'] as $key) {
		            	$customers[]=$key->application_no;
		            }
				}
		if(count($data['customers'])==0){	
			$customers=NULL;
		}

		if(Input::get('print')=="print"){
					$pdfTemplate = View::make('admin.new_customers.new_cust_pdf', $data)->render();
			   		$pdf = App::make('dompdf');
			   		$pdf->loadHTML($pdfTemplate);
			   		return $pdf->download($feasible.'-'.$from.'-TO-'.$to.'.pdf');
	   		}
           	$activation= DB::table('new_customers')->
           	whereIn('application_no',$customers)->select('id','application_no','first_name','application_date','address1',
			'address2','address3','phone','remarks','assign_employee')->orderBy('application_no','desc');
        										
        $active = Datatables::of($activation)->addColumn('feasible','@if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->activation != 1)
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->fiber==1)
                            <span class="btn btn-minier btn-success">F</span>
                        @else
                            <span class="btn btn-minier btn-danger">F</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->splicing==1)
                            <span class="btn btn-minier btn-success">s</span>
                        @else
                            <span class="btn btn-minier btn-danger">s</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->ethernet==1)
                            <span class="btn btn-minier btn-success">E</span>
                        @else
                            <span class="btn btn-minier btn-danger">E</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->hut_boxes==1)
                            <span class="btn btn-minier btn-success">H</span>
                        @else
                            <span class="btn btn-minier btn-danger">H</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->configuration)
                            <span class="btn btn-minier btn-success">c</span>
                        @else
                            <span class="btn btn-minier btn-danger">c</span>
                        @endif
                    @else
                        <span class="btn btn-minier btn-danger">Rejectied</span>
                    @endif',false)->addColumn('AssignTo','<button name="assign" value="{{$id}}"  onclick="assign({{$id}},1)" 
                         class="btn btn-minier btn-primary assign emp_{{$id}} {{$id}}">assgin
                        </button>
                 			',false)->addColumn('Check Box','<button name="comp" value="{{$id}}" onclick="assign({{$id}},2)"
                         class="btn btn-minier btn-danger finish comp_{{$id}}">notfinised
                        </button>',false)->make();
		return $active;
				
   	}			

   	public function NewCustomerPrintAjax(){
		$feasible=Input::get('feasible');
		$employee=Input::get('employee');
		$from = Input::get('from');
		$to = Input::get('to');
		$print=Input::get('print');

		if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
			$to_date = date("Y-m-d H:i:s");
			$from_date = date("Y-m-d H:i:s",strtotime("-2 month",strtotime($to_date)));
		}else{
			$from_date = date("Y-m-d H:i:s",strtotime($from));
			$to_date = date("Y-m-d H:i:s",strtotime($to));
		}
				if(count($feasible)!=0){
					$data['customers']=NewCustomer::CheckCustomerDetWithDate($feasible,NULL,$from_date,$to_date,$employee);
					$customers=$data['customers'];
					$data['custom']=DB::table('new_customers')->whereIn('application_no',$customers)->get();
				}else{
					$search=NULL;
					$data['customers'] =NewCustomer::CheckCustomerDet($search,NULL);
		            foreach ($data['customers'] as $key) {
		            	$customers[]=$key->application_no;
		            }
				}
		if(count($data['customers'])==0){	
			$customers=NULL;
		}

		if(Input::get('print')=="print"){
					$pdfTemplate = View::make('admin.new_customers.new_cust_pdf', $data)->render();
			   		$pdf = App::make('dompdf');
			   		$pdf->loadHTML($pdfTemplate);
			   		return $pdf->download($feasible.'-'.$from.'-TO-'.$to.'.pdf');
	   		}

           	$activation= DB::table('new_customers')->
           	whereIn('application_no',$customers)->select('application_no','first_name','application_date','address1',
			'address2','address3','phone')->orderBy('application_no','desc');
        										
        $active = Datatables::of($activation)->addColumn('feasible','@if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->activation != 1)
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->fiber==1)
                            <span class="btn btn-minier btn-success">F</span>
                        @else
                            <span class="btn btn-minier btn-danger">F</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->splicing==1)
                            <span class="btn btn-minier btn-success">s</span>
                        @else
                            <span class="btn btn-minier btn-danger">s</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->ethernet==1)
                            <span class="btn btn-minier btn-success">E</span>
                        @else
                            <span class="btn btn-minier btn-danger">E</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->hut_boxes==1)
                            <span class="btn btn-minier btn-success">H</span>
                        @else
                            <span class="btn btn-minier btn-danger">H</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->configuration)
                            <span class="btn btn-minier btn-success">c</span>
                        @else
                            <span class="btn btn-minier btn-danger">c</span>
                        @endif
                    @else
                        <span class="btn btn-minier btn-danger">Rejectied</span>
                    @endif',false)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
                                <a href="/admin/new-customers/{{$application_no}}/pre-activation-show" >
                                 <span class="btn btn-minier btn-primary">show</span>
                                </a>
                        </div>',false)->make();
		return $active;
				
   	}





	public function NewCustomerListAjax()
	{
			$area = Input::get('area');
			$areas=explode(',',$area);
			$from = Input::get('from');
			$to = Input::get('to');

		if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
			$to_date = date("Y-m-d H:i:s");
			$from_date = date("Y-m-d H:i:s",strtotime("-2 month",strtotime($to_date)));
		}else{
			$from_date = date("Y-m-d H:i:s",strtotime($from));
			$to_date = date("Y-m-d H:i:s",strtotime($to));
		}
				if(count($area)!=0){
					$data['customers']=NewCustomer::CheckCustomerDetWithDate(NULL,$areas,$from_date,$to_date,NULL);
					$customers=$data['customers'];
				}else{
					$search=NULL;
					$data['customers'] =NewCustomer::CheckCustomerDet($search,NULL);
		            foreach ($data['customers'] as $key) {
		            	$customers[]=$key->application_no;
		            }
				}
		if(count($customers)==0){	
			$customers=NULL;
		}
           	$activation= DB::table('new_customers')->
           	whereIn('application_no',$customers)->select('application_no','first_name','application_date','address1',
			'address2','address3','phone')->orderBy('application_no','desc');

        $active = Datatables::of($activation)->addColumn('feasible','@if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->activation != 1)
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->fiber==1)
                            <span class="btn btn-minier btn-success">F</span>
                        @else
                            <span class="btn btn-minier btn-danger">F</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->splicing==1)
                            <span class="btn btn-minier btn-success">s</span>
                        @else
                            <span class="btn btn-minier btn-danger">s</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->ethernet==1)
                            <span class="btn btn-minier btn-success">E</span>
                        @else
                            <span class="btn btn-minier btn-danger">E</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->hut_boxes==1)
                            <span class="btn btn-minier btn-success">H</span>
                        @else
                            <span class="btn btn-minier btn-danger">H</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->configuration)
                            <span class="btn btn-minier btn-success">c</span>
                        @else
                            <span class="btn btn-minier btn-danger">c</span>
                        @endif
                    @else
                        <span class="btn btn-minier btn-danger">Rejectied</span>
                    @endif',false)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
                                <a href="/admin/new-customers/{{$application_no}}/pre-activation-show" >
                                 <span class="btn btn-minier btn-primary">show</span>
                                </a>
                        </div>',false)->make();
		return $active;
	}




   	public function NewCustomerRejectAjax()
	{
			$area = Input::get('area');
			$areas=explode(',',$area);
			$from = Input::get('from');
			$to = Input::get('to');

		if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
			$to_date = date("Y-m-d H:i:s");
			$from_date = date("Y-m-d H:i:s",strtotime("-2 month",strtotime($to_date)));
		}else{
			$from_date = date("Y-m-d H:i:s",strtotime($from));
			$to_date = date("Y-m-d H:i:s",strtotime($to));
		}
				if(count($area)!=0){
					$customers= DB::table('new_customers')->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
           							->whereBetween('new_customers.application_date',[$from_date,$to_date])
           							->where('pre_activation_status.activation','=',1)
           							->whereIn('new_customers.address3',$areas)
           							->select('new_customers.application_no','new_customers.first_name','new_customers.application_date','new_customers.address1',
									'new_customers.address2','new_customers.address3','new_customers.phone')->orderBy('new_customers.application_no','desc');
				}else{
					$customers= DB::table('new_customers')->join('pre_activation_status','pre_activation_status.crf_no','=','new_customers.application_no')
           						->whereBetween('new_customers.application_date',[$from_date,$to_date])
           						->where('pre_activation_status.activation','=',1)
           						->select('new_customers.application_no','new_customers.first_name','new_customers.application_date','new_customers.address1',
									'new_customers.address2','new_customers.address3','new_customers.phone')->orderBy('new_customers.application_no','desc');
		          
				}
		if(count($customers)==0){	
			$customers=NULL;
		}
           	$activation=$customers;

        $active = Datatables::of($activation)->addColumn('feasible','@if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->activation != 1)
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->fiber==1)
                            <span class="btn btn-minier btn-success">F</span>
                        @else
                            <span class="btn btn-minier btn-danger">F</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->splicing==1)
                            <span class="btn btn-minier btn-success">s</span>
                        @else
                            <span class="btn btn-minier btn-danger">s</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->ethernet==1)
                            <span class="btn btn-minier btn-success">E</span>
                        @else
                            <span class="btn btn-minier btn-danger">E</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->hut_boxes==1)
                            <span class="btn btn-minier btn-success">H</span>
                        @else
                            <span class="btn btn-minier btn-danger">H</span>
                        @endif
                        @if(DB::table("pre_activation_status")->where("crf_no",$application_no)->first()->configuration)
                            <span class="btn btn-minier btn-success">c</span>
                        @else
                            <span class="btn btn-minier btn-danger">c</span>
                        @endif
                    @else
                        <span class="btn btn-minier btn-danger">Rejectied</span>
                    @endif',false)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
                                <a href="/admin/new-customers/{{$application_no}}/pre-activation-show" >
                                 <span class="btn btn-minier btn-primary">show</span>
                                </a>
                        </div>',false)->make();
		return $active;
	}


	public function NewCustomerAssignUpdate()
	{
		$feasible = Input::get('feasible');
		$employee = Input::get('employee');
		$id=Input::get('crf_no');

		if($feasible && $employee && $id ){

		$activation = NewCustomer::where('id','=',$id)->first();
        $pre_activation = PreActivationStatus::where('crf_no','=',$activation->application_no)->first();
		$crf_no=$pre_activation->crf_no;
		if($feasible=="splicing"){
			if($pre_activation->fiber == 1){
				$pre_activation->splicing =$employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
				$pre_activation->splicing_updated_at = $employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
				$pre_activation->save();
					$status = "success";
			}else{
					$status = "Updation failed Because should update after fiber";
			}
		}else if($feasible=="ethernet"){
			if($pre_activation->fiber == 1){
					$pre_activation->ethernet =$employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
					$pre_activation->ethernet_updated_at =$employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
					$pre_activation->save();

					$pre_activation->hut_boxes =$employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
					$pre_activation->hut_boxes_updated_at =$employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
					$pre_activation->save();
					$status = "success";
				}else{
					$status = "Updation failed Because should update after fiber and splicing";
				}
		}else if($feasible=="configuration"){
			if($pre_activation->fiber == 1 && $pre_activation->splicing == 1 && $pre_activation->ethernet == 1){
					$pre_activation->configuration =$employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
					$pre_activation->configuration_updated_at =$employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
					$pre_activation->save();
					$status = "success";
				}else{
					$status = "Updation failed Because should update after fiber and splicing and ethernet";
				}
		}else if($feasible=="fiber"){
                    $pre_activation->fiber = $employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
					$pre_activation->feasible = $employee =="completed" ? 1:($employee=="uncompleted" ? 0:$this->AssignTo($crf_no,$employee));
					$pre_activation->fiber_updated_at = $employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
					$pre_activation->feasible_updated_at =$employee =="completed" ?date('Y-m-d H:m:s'):($employee=="uncompleted" ? 0:0);
					$pre_activation->save();
					$status = "success";
					
		}else{
			$response = array('found' => "flase",'pre_status' => "nothing",);
			return Response::json($response);
		}
		$response = array('found' => "true",'pre_status' =>$status,);
			return Response::json($response);
	}else{
		$response = array('found' => "flase",'pre_status' => "invaild",);
			return Response::json($response);
		}

	}
	public function AssignTo($crf_no,$employee){
        $feasible=Input::get('feasible');
		$new_customer = NewCustomer::where('application_no','=',$crf_no)->first();
		$new_customer->assign_employee=$employee;
		$new_customer->save();
        
        $new_customer_pre = PreActivationStatus::where('crf_no','=',$crf_no)->first();

        if($feasible=="fiber"){
            $new_customer_pre->assign_to_fiber=$employee;
            $new_customer_pre->save();
        }else if($feasible=="splicing"){
            $new_customer_pre->assign_to_splicing=$employee;
            $new_customer_pre->save();
        }else if($feasible=="ethernet"){
            $new_customer_pre->assign_to_ethernet=$employee;
            $new_customer_pre->save();
        }else if($feasible=="configuration"){
            $new_customer_pre->assign_to_configuration=$employee;
            $new_customer_pre->save();
        }else if($feasible=="hut_boxes"){
            $new_customer_pre->assign_to_hut_boxes=$employee;
            $new_customer_pre->save();
        }
	}

    public function ShowEmployeeGet(){
        $data['employees']=Employee::all();
       return View::make('admin.reports.employee_work_det',$data);

    } 

    public function ShowEmployeeAjax(){
        
        $from = Input::get('from');
        $to = Input::get('to');

        if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
            $to_date = date("Y-m-d 00:00:00");
            $from_date = date("Y-m-d 00:00:00",strtotime("-2 month",strtotime($to_date)));
        }else{
            $from_date = date("Y-m-d 00:00:00",strtotime($from));
            $to_date = date("Y-m-d 00:00:00",strtotime($to));
        }

        $pre_activation_status=PreActivationStatus::whereBetween('created_at',[$from_date,$to_date])->get();

        if(count($pre_activation_status)!=0){


        foreach ($pre_activation_status as $key) {
                $created_at[]=date('Y-m-d',strtotime($key->created_at));
        }

        $pre_activation_unique=array_unique($created_at);
        
        foreach ($pre_activation_unique as $key) {
                $start=date('Y-m-d 00:00:00',strtotime($key));
                $end=date('Y-m-d 00:00:00',strtotime('+1 day',strtotime($key)));
                
                $data[]=array('created_at'=>$key,
                    'fiber'=>PreActivationStatus::whereBetween('fiber_updated_at',[$start,$end])->sum('fiber'),
                    'splicing'=>PreActivationStatus::whereBetween('fiber_updated_at',[$start,$end])->sum('splicing'),
                    'ethernet'=>PreActivationStatus::whereBetween('fiber_updated_at',[$start,$end])->sum('ethernet'),
                    'hut_boxes'=>PreActivationStatus::whereBetween('fiber_updated_at',[$start,$end])->sum('hut_boxes'),
                    'configuration'=>count(CusDet::whereBetween('created_at',[$start,$end])->get()));
        }
         
    }else{
            $data = array(array('created_at'=>'Data Not available','fiber'=>'NiLL','splicing'=>'NiLL',
                                'ethernet'=>'NiLL','hut_boxes'=>'NiLL','configuration'=>'NiLL'));
    }
    $results = array(
            "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
          "aaData"=>$data);

        return json_encode($results);

    }


}