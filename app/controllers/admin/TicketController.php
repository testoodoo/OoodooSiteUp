<?php

namespace Admin;

use View,Role,Bill, Input,DB,Redirect,Ticket,Masterdata,Status,Auth,Employee;
use PaymentTransaction,PDF,File,Mail,App,DOMPDF,Datatables,CSV,Response,ExoCallLand;

class TicketController extends \BaseController {

	protected $config;

	public function index(){
			$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('admin.tickets.index',$data);
	}

	public function AjaxTicket(){

		$status_get=Input::get('status');
		$area_get=Input::get('area');
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
		
		$areas=Masterdata::where('type','area')->get();
		foreach ($areas as $key) {
			$area_in[]=$key->name;
		}

		if(is_array($area_get)){
			$area=$area_get;
			if($area[0]=="all_area"){
				$area=$area_in;	
			}
		}else if(!is_null($area_get) && $area_get!="null"){
			$area=explode(',',$area_get);
			if($area[0]=="all_area"){
				$area=$area_in;
			}
		}else{
			$area=NULL;
		}


		if(is_array($status_get)){
			$status=$status_get;
		}elseif(!is_null($status_get) && $status_get!= "null" ){
			$status=explode(',',$status_get);
		}else{
			$status=NULL;
		}
		//var_dump($area);die;
		$result=Ticket::TicketStatus($status,$area,$from_date,$to_date,$from,$to);

	   	if($print=="print"){
	   		$data['tickets']=$result['tickets'];
		   	$pdfTemplate = View::make('admin.tickets.pdf3', $data)->render();
	   		$pdf = App::make('dompdf');
	   		$pdf->loadHTML($pdfTemplate);
	   		return $pdf->download('sample_file.pdf');
	   		/*$arr = $result['tickets']->toArray();
	   		return CSV::fromArray($pdfTemplate)->render();*/
	   	}


        $ticket_det = Datatables::of($result['ticket'])->addColumn('ticket_type','@if($status=DB::table("tickets")->where("ticket_no",$ticket_no)->first())
	        																@if($type=DB::table("master_data")->where("id",$status->ticket_type_id)->first())
	        																	{{$type->name}}
	        																@else
	        																	Not Found
	        																@endif
        																@endif',false)
        									->addColumn('status','@if($status=DB::table("tickets")->where("ticket_no",$ticket_no)->first())
        																@if($tic_status=DB::table("master_data")->where("id",$status->status_id)->first())
        																	{{$tic_status->name}}
        																@else
        																	Not Found
        																@endif
        															@endif',false)
        									->addColumn('operation','<div class="hidden-sm hidden-xs action-buttons">
        														<a class="blue" href="/admin/ticket/view/{{$id}}">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a> 
                 												</div>',false)->make();

        return $ticket_det;
		
	}

	public function MyTickets(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('admin.tickets.mytickets',$data);
	}

	public function MyTicketsAjax()
	{
		$employee=Auth::employee()->get()->employee_identity;
		$status_get=Input::get('status');
		$area_get=Input::get('area');
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
		
		$areas=Masterdata::where('type','area')->get();
		foreach ($areas as $key) {
			$area_in[]=$key->name;
		}

		if(is_array($area_get)){
			$area=$area_get;
			if($area[0]=="all_area"){
				$area=$area_in;	
			}
		}else if(!is_null($area_get) && $area_get!="null"){
			$area=explode(',',$area_get);
			if($area[0]=="all_area"){
				$area=$area_in;
			}
		}else{
			$area=NULL;
		}


		if(is_array($status_get)){
			$status=$status_get;
		}elseif(!is_null($status_get) && $status_get!= "null" ){
			$status=explode(',',$status_get);
		}else{
			$status=NULL;
		}
		//var_dump($area);die;
		$result=Ticket::TicketStatus($status,$area,$from_date,$to_date,$from,$to);

		if(count($result['tickets'])!=0){
			foreach ($result['tickets'] as $key) {
				$id[]=$key->id;
			}
		}else{
			$id=NULL;
		}

	   	if($print=="print"){
	   		$data['tickets']=Ticket::whereIn('id',$id)->whereIn('id',$id)->where('assigned_to',$employee)->get();
		   	$pdfTemplate = View::make('admin.tickets.pdf3', $data)->render();
	   		$pdf = App::make('dompdf');
	   		$pdf->loadHTML($pdfTemplate);
	   		return $pdf->download('sample_file.pdf');
	   	}

		$ticket=DB::table('tickets')->select('id','ticket_no','name','mobile','address','area','requirement')->whereIn('id',$id)->where('assigned_to',$employee)->orderBy('id','desc');
        
        $ticket_det = Datatables::of($ticket)->addColumn('ticket_type','@if($status=DB::table("tickets")->where("ticket_no",$ticket_no)->first())
	        																@if($type=DB::table("master_data")->where("id",$status->ticket_type_id)->first())
	        																	{{$type->name}}
	        																@else
	        																	Not Found
	        																@endif
        																@endif',false)
        									->addColumn('status','@if($status=DB::table("tickets")->where("ticket_no",$ticket_no)->first())
        																@if($tic_status=DB::table("master_data")->where("id",$status->status_id)->first())
        																	{{$tic_status->name}}
        																@else
        																	Not Found
        																@endif
        															@endif',false)
        									->addColumn('operation','<div class="hidden-sm hidden-xs action-buttons">
        														<a class="blue" href="/admin/ticket/view/{{$id}}">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a> 
                 												</div>',false)->make();

        return $ticket_det;

	}
	public function create(){
		$data['ticket'] = new Ticket();
		$data['ticket_types'] = Masterdata::where('type','=','ticket_type')->get();
		$data['cities'] = Masterdata::where('type','=','city')->get();
		$data['areas'] = Masterdata::where('type','=','area')->get();
		$data['employee_identity'] = Employee::all();
		return View::make('admin.tickets.create',$data);	
	}

	public function store(){
		$ticket = new Ticket();
		$ticket->ticket_type_id =1;
		$ticket->name = Input::get('name');
		if (Input::get('account_id')) {
			$ticket->account_id = Input::get('account_id');
		}
		$ticket->mobile = Input::get('mobile');
		$ticket->email = Input::get('email');
		$ticket->address = Input::get('address');
		$ticket->city_id = Input::get('city_id');
		$ticket->area = Input::get('area');
		$ticket->requirement = Input::get('requirement');
		$ticket->assigned_by = Auth::employee()->get()->employee_identity;
		$ticket->assigned_to =100025;
		$ticket->active = 1;
		$ticket->save();

		$ticket->generateTicketNo();
		$ticket->updateStatus();

		return Redirect::route('admin.tickets.index')
				    ->with('success','Succesfully Created');	

	}

	public function view($id){
		$ticket = Ticket::find($id);
		if (!is_null($ticket)) {
			$data['ticket'] = $ticket;
			$data['ticket_status'] = Masterdata::where('type','=','ticket_status')->get();
			$data['status_list']  = Masterdata::where('type','=','ticket_status')->get();
			$data['employees'] = Employee::all();
			return View::make('admin.tickets.view',$data); 
		}
		return Redirect::to('/admin/ticket/index')->with('failure','Ticket Not found');
	}

	public function genericStore(){
		$ticket = new Ticket();
		if(Input::get('crf_no')){
	    	$ticket->crf_no = Input::get('crf_no');
		}else{
			$ticket_open=Ticket::where('account_id',Input::get('account_id'))->where('status_id',3)->first();
			$ticket_process=Ticket::where('account_id',Input::get('account_id'))->where('status_id',5)->first();
			if($ticket_open || $ticket_process){
				return Redirect::back()->with('failure','Ticket has been taken which status open');
			}
			$ticket->account_id = Input::get('account_id');
		}
		$ticket->name = Input::get('name');
		$ticket->mobile = Input::get('mobile');
		$ticket->email = Input::get('email');
		$ticket->address = Input::get('address');
		$ticket->ticket_type_id = Input::get('ticket_type_id');
		$ticket->city_id = Input::get('city_id');
		$ticket->requirement = Input::get('requirement');
		$ticket->area = Input::get('area');
		$ticket->assigned_to =Input::get('employee_id');
		$ticket->assigned_by = Auth::employee()->get()->employee_identity;
		$ticket->active = 1;
		$ticket->save();
		$ticket->generateTicketNo();
		$ticket->updateStatus();
		$ticket->AssignUpdate($ticket->requirement);

		$employee=Employee::where('employee_identity','=',Input::get('employee_id'))->get()->first();
		 if($employee){
			$senderId = "OODOOS";
			$message = 'compilant '.'Ticket No '.$ticket->ticket_no.' '.$ticket->name.' '.$ticket->account_id.' '.$ticket->mobile.' '.$ticket->address;
			$mobileNumber = $employee->mobile;		

			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message); 
		}

		return Redirect::back()->with('success','Succesfully Created');		
	}

	public function AssignTicket($id){
		$ticket = Ticket::find($id);
		if (!is_null($ticket)) {
			$data['ticket'] = $ticket;
			$data['ticket_area'] = Masterdata::where('type','=','area')->get();
			$data['cities']  = Masterdata::where('type','=','city')->get();
			$data['employees'] = Employee::all();
			return View::make('admin.tickets.assign_tickets',$data); 
		}
		return Redirect::to('/admin/ticket/index')->with('failure','Ticket Not found');
	}

	public function SendTicket(){

		$employee_id=Input::get('employee_id');
		$ticket_no=Input::get('ticket_no');
		$mobile=Input::get('phone');
		$employee=Employee::where('employee_identity','=',$employee_id)->get()->first();
		$ticket=Ticket::where('ticket_no','=',$ticket_no)->get()->first();
		if($employee){
			if($ticket->assigned_to==$employee_id){
					return Redirect::back()->with('failure','Ticket aleady assigned failure to assign');
			}
		$address=$ticket->address;
		$area=$ticket->area;
		$ticket_no=$ticket->ticket_no;
		if($ticket->account_id)
		{
			$account_id=$ticket->account_id;
		}else{
			$account_id=$ticket->crf_no;
		}
		$name=$ticket->name;
		
		$ticket->assigned_to=$employee_id;
		$ticket->assigned_by=Auth::employee()->get()->employee_identity;
		$ticket->save();

		$ticket->AssignUpdate(Input::get('remarks'));

			$senderId = "OODOOS";
			$message = 'compilant '.'Ticket No '.$ticket_no.' '.$name.' '.$account_id.' '.$mobile.' '.$address;
			$mobileNumber = $employee->mobile;		

			$return = PaymentTransaction::sendsms($mobileNumber, $senderId, $message); 
		
			return Redirect::back()->with('success','Ticket Assigned Succesfully '); 
		}
		return Redirect::back()->with('failure','Ticket Not Assigned and Employee ID NOT Found');
	}

	public function Pdf(){
		$area = Input::get('area');
		$from = Input::get('from_date');
		$to = Input::get('to_date');
		$from_date = date("Y-m-d H:i:s",strtotime($from));
		$to_date = date("Y-m-d H:i:s",strtotime($to));
		$to_date = date('Y-m-d H:i:s', strtotime($to_date . ' + 1 day'));
		
			$tickets=Ticket::whereIn('status_id',array('3'))
	                                ->whereIn('ticket_type_id',array('1'))
	                                ->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->orderBy('id','desc')->get();
	    	if(count($tickets)!=0){
						$count=count($tickets);
	        		$data['tickets']=Ticket::whereIn('status_id',array('3'))
	                                ->whereIn('ticket_type_id',array('1'))
	                                ->whereBetween('created_at',[$from_date,$to_date])->whereIn('area',$area)
	                                  ->orderBy('id','desc')->paginate($count);
				$pdfTemplate = View::make('admin.tickets.pdf3', $data)->render();
   				$pdf = App::make('dompdf');
   				$pdf->loadHTML($pdfTemplate);
   				return $pdf->download('sample_file.pdf');

	           }else{
	    		return Redirect::route('admin.tickets.index')
				    ->with('failure','Invaild Inputs Area and date range and NOT available');
				}
	    
	}

	public function ExoCallStatus(){
		return View::make('admin.tickets.exo_call_status');
	}


	public function ExoCallStatusAjax(){
		
		$call_log= DB::table('exo_call_log')->select('call_sid','start_time','end_time',
		'call_from','call_to','call_status','recording_url')
		->orderBy('start_time','desc');
        
        $call_logs = Datatables::of($call_log)->make();
       
        return $call_logs;
	}

	public function TicketDetails(){
		
		$status_get=Input::get('status');
		$area_get=Input::get('area');
		$from = Input::get('from');
		$to = Input::get('to');
		$print=Input::get('print');
		
		if((!$from && !$to)||($from && $to)){
			$to_date = date("Y-m-d H:i:s");
			$from_date = date("Y-m-d H:i:s",strtotime("-2 month",strtotime($to_date)));
		}else{
			$from_date = date("Y-m-d H:i:s",strtotime($from));
			$to_date = date("Y-m-d H:i:s",strtotime($to));
		}
		
		$areas=Masterdata::where('type','area')->get();
		foreach ($areas as $key) {
			$area_in[]=$key->name;
		}

		if(is_array($area_get)){
			$area=$area_get;
			if($area[0]=="all_area"){
				$area=$area_in;	
			}
		}else if(!is_null($area_get) && $area_get){
			$area=explode(',',$area_get);
			if($area[0]=="all_area"){
				$area=$area_in;
			}
		}else{
			$area=NULL;
		}


		if(is_array($status_get)){
			$status=$status_get;
		}elseif(!is_null($status_get) && $status_get){
			$status=explode(',',$status_get);
		}else{
			$status=NULL;
		}

		$result=Ticket::TicketStatus($status,$area,$from_date,$to_date,$from,$to);


		if(count($result['tickets'])!=0){
			foreach ($result['tickets'] as $key) {
					$ids[]=$key->id;
			}
		}else{
			$ids[]=NULL;
		}

		
		$open=Ticket::where('status_id',3)->whereIn('id',$ids)->get();
		$close=Ticket::where('status_id',4)->whereIn('id',$ids)->get();
		$process=Ticket::where('status_id',5)->whereIn('id',$ids)->get();
		$invaild=Ticket::where('status_id',6)->whereIn('id',$ids)->get();
		$trash=Ticket::where('status_id',7)->whereIn('id',$ids)->get();

			$response = array(
						'found' => "true",
						'open' => count($open),
						'close' => count($close),
						'process' =>count($process),
						'invaild' =>count($invaild),
						'trash' => count($trash)
					);

			return Response::json($response);

	}

	public function ExoCallMissed(){
		return View::make('admin.tickets.exo_call_missed');
	}

	public function ExoCallMissedAjax(){

		$call_missed= DB::table('exo_call_missed')->select('call_sid','start_time','end_time',
		'call_from','call_to','call_status')->orderBy('created_at','asc');
        
        $call_missed = Datatables::of($call_missed)->addColumn('call_back','<spam class="status{{$call_sid}} btn btn-minier btn-success" onclick="callback({{$call_from}},{{$call_to}},{{$call_sid}})">
																Call Back!
															</span>',false)->make();
       
        return $call_missed;
	}

	public function ExoCallBack(){

		$from=Input::get('from');
		$to=Input::get('to');

		$exotel_sid = "oodoo";
		$exotel_token = "ee059e7570bad28fe2701604d6efc8d6a11ffa39";
		 
		$url = "https://".$exotel_sid.":".$exotel_token."@twilix.exotel.in/v1/Accounts/".$exotel_sid."/Calls/connect";
		
		$post_data = array(
		    'From' => $from,
		    'To' => $to,
		    'CallerId' =>$to,//<Your-Exotel-virtual-number>
		    'Url' => $url,
		    'CallType' => "trans"
		);
		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		 
		$http_result = curl_exec($ch);
		$error = curl_error($ch);
		$http_code = curl_getinfo($ch ,CURLINFO_HTTP_CODE);
		 
		curl_close($ch);
		 
		$callOutput=simplexml_load_string($http_result) or die("Error: Cannot create object");

		//var_dump($callOutput);die;

		if(count($callOutput->Call) != 0) {
		$callLand=new ExoCallLand();
		$callLand->call_sid=$callOutput->Call->Sid;
		$callLand->from_no=$callOutput->Call->From;
		$callLand->to_no=$callOutput->Call->To;
		$callLand->dial_call_duration=$callOutput->Call->Duration;
		$callLand->direction=$callOutput->Call->Direction;
		$callLand->start_time=$callOutput->Call->StartTime;
		$callLand->end_time=$callOutput->Call->EndTime;
		$callLand->call_type=$callOutput->Call->CallType;
		$callLand->recording_url=$callOutput->Call->Recording_Url;
		$callLand->dial_whom_number='';
		$callLand->created='';
		$callLand->flow_id='';
		$callLand->tenant_id='';
		$callLand->call_from=$callOutput->Call->From;
		$callLand->call_to=$callOutput->Call->To;
		$callLand->dial_call_status=$callOutput->Call->Status;
		$callLand->forwarded_from=$callOutput->Call->ForwardedFrom;
		$callLand->process_status=$callOutput->Call->Status;
		$callLand->save();
			$response = array(
						'found' => "true",
						'status' => "Processing",
					);
			return Response::json($response);
		}
		return Response::json(array('found' => "false",'status'=>json_encode($callOutput->RestException->Message)));
	}

	public function SupportAlert(){
		return View::make('admin.tickets.support_alert');
	}

	public function OperationAlert(){
		return View::make('admin.tickets.operation_alert');
	}

	public function SupportAlertAjax(){
		$ticket_info= DB::table('ticket_info')->select('ticket_id','message')->where('message_type','update_support')->where('updation',0)->orderBy('ticket_id','desc');
        $ticket = Datatables::of($ticket_info)->addColumn('ticket_no','{{DB::table("tickets")->where("id",$ticket_id)->first()->ticket_no}}',false)
        														->addColumn('operation','<div class="hidden-sm hidden-xs action-buttons">
        														<a class="blue" href="/admin/ticket/view/{{$ticket_id}}">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a> 
                 												</div>',false)->make();
        return $ticket;
	}

	public function OperationAlertAjax(){
		$ticket_info= DB::table('ticket_info')->select('ticket_id','message')->where('message_type','update_operation')->where('updation',0)->orderBy('ticket_id','desc');
        $ticket = Datatables::of($ticket_info)->addColumn('ticket_no','{{DB::table("tickets")->where("id",$ticket_id)->first()->ticket_no}}',false)
											->addColumn('operation','<div class="hidden-sm hidden-xs action-buttons">
													<a class="blue" href="/admin/ticket/view/{{$ticket_id}}">
														<i class="ace-icon fa fa-search-plus bigger-130"></i>
													</a> 
     												</div>',false)->make();
        return $ticket;
	}



}
