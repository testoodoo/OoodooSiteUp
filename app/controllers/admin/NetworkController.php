<?php

namespace Admin;
use View,Input,Response,Redirect,DB,Datatables,ServerDetails,OtdrDetails,Masterdata,Incident,Employee,IncidentUpdate,Auth,CusDet;

class NetworkController extends \BaseController {

	public function ServerStatus(){
		return View::make('admin.networks.index');		

	}

	public function ServerStatusAjax(){
		$server_det= DB::table('server_det')->select('id','name','purpose','Description','location','last_uptime','last_downtime','status');
        $server = Datatables::of($server_det)->make();
        return $server;		

	}

	public function ServerCreate(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('admin.networks.server_create',$data);		

	}

	public function ServerPost(){
		
		$server=new ServerDetails();
		$server->ip=Input::get('ip');
		$server->name=Input::get('name');
		$server->hostname=Input::get('hostname');
		$server->port=Input::get('port');
		$server->purpose=Input::get('purpose');
		$server->Description=Input::get('discription');
		$server->location=Input::get('location');
		$server->save();

		return Redirect::route('admin.network.server-status')
					->with('success','Network Added Succesfully');


	}

	public function OtdrCreate(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('admin.networks.otdr_create',$data);		

	}

	public function OtdrPost(){
		$otdr=new OtdrDetails();
		$otdr->location_a=Input::get('location_a');
		$otdr->location_b=Input::get('location_b');
		$otdr->area_a=Input::get('area_a');
		$otdr->area_b=Input::get('area_b');
		$otdr->distance=Input::get('distance');
			if($incident_id=Input::get('incident_id')){
				foreach ($incident_id as $key) {
					$otdr->incident_id=$key;
					$otdr->save();
				}
				return Redirect::back()
					->with('success','Oddr Details Added Succesfully');
			}
		$otdr->save();

		return Redirect::route('admin.network.otdr')
					->with('success','Oddr Details Added Succesfully');

	}

	public function Otdr(){
		return View::make('admin.networks.otdr_show');
	}

	public function OtdrAjax(){
		$otdr_det= DB::table('otdr_det')->select('id','location_a','area_a','location_b','area_b','distance');
        $otdr = Datatables::of($otdr_det)->make();
        return $otdr;

	}

	public function Incident(){
		$data['areas'] =Masterdata::where('type','area')->get();
		return View::make('admin.networks.incident',$data);
	}

	public function IncidentAjax(){
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
		$result=Incident::IncidentStatus($status,$area,$from_date,$to_date,$from,$to);

	   	if($print=="print"){
	   		$data['tickets']=$result['tickets'];
		   	$pdfTemplate = View::make('admin.tickets.pdf3', $data)->render();
	   		$pdf = App::make('dompdf');
	   		$pdf->loadHTML($pdfTemplate);
	   		return $pdf->download('sample_file.pdf');
	   		/*$arr = $result['tickets']->toArray();
	   		return CSV::fromArray($pdfTemplate)->render();*/
	   	}

        $ticket_det = Datatables::of($result['ticket'])->addColumn('ticket_type','@if($status=DB::table("incident")->where("ticket_no",$ticket_no)->first())
	        																@if($type=DB::table("master_data")->where("id",$status->ticket_type_id)->first())
	        																	{{$type->name}}
	        																@else
	        																	Not Found
	        																@endif
        																@endif',false)
        									->addColumn('status','@if($status=DB::table("incident")->where("ticket_no",$ticket_no)->first())
        																@if($tic_status=DB::table("master_data")->where("id",$status->status_id)->first())
        																	{{$tic_status->name}}
        																@else
        																	Not Found
        																@endif
        															@endif',false)
        									->addColumn('operation','<div class="hidden-sm hidden-xs action-buttons">
        														<a class="blue" href="/admin/network/incident_show/{{$id}}">
																	<i class="ace-icon fa fa-search-plus bigger-130"></i>
																</a> 
                 												</div>',false)->make();

        return $ticket_det;

	}

	public function IncidentShow($id){
		$ticket = Incident::find($id);
		if (!is_null($ticket)) {
			$data['ticket'] = $ticket;
			$data['ticket_status'] = Masterdata::where('type','=','ticket_status')->get();
			$data['status_list']  = Masterdata::where('type','=','ticket_status')->get();
			$data['areas'] =Masterdata::where('type','area')->get();
			$data['incident'] =Incident::where('status_id','3')->where('id','!=',$id)->get();
			$data['employees'] = Employee::all();
			return View::make('admin.networks.view',$data); 
		}
		return Redirect::to('/admin/network/incident')->with('failure','Incident Not found');

	}

	public function IncidentUpdate(){
		$incident_id=Input::get('incident_id');
		if($incident_id){
			foreach ($incident_id as $key) {
				$ticket = Incident::find($key);
				if (!is_null($ticket)) {
					$incident=new IncidentUpdate();
					$incident->incident_id=$key;
					$hour=Input::get('hour');
					$date= date("Y-m-d H:i:s",strtotime("+".$hour." hour",strtotime(date('Y-m-d H:i:s'))));
					$incident->up_time=$date;
					$incident->down_time=$ticket->created_at;
					$incident->hour=$hour;
					$incident->remarks=Input::get('remarks');
					$incident->assigned_to=Input::get('assigned_to');
					$incident->assigned_by=Auth::employee()->get()->employee_identity;
					$incident->save();

					$ticket->assigned_by=Auth::employee()->get()->employee_identity;
					$ticket->assigned_to=Input::get('assigned_to');
					$ticket->save();
				}

			}
			return Redirect::back()->with('success','Incident Updated Succesfully');
		}else{
			return Redirect::back()->with('failure','Incident Invaild');	
		}
	}

	public function SessionArea(){
		return View::make('admin.networks.session_area');
	}

	public function SessionAreaAjax(){
		$area=Masterdata::where('type','area')->get();

		foreach ($area as $key) {
		$data[] = array(
			'area'=>$key->name,
			'total'=>count(DB::table('cust_det')->where('address3',$key->name)->get()),
			'active'=> count(DB::table('cust_det')->select('cust_det.account_id')
				->join('jactive_session','jactive_session.account_id','=','cust_det.account_id')->where('cust_det.address3','=',$key->name)->get()),
			'fault'=> count(DB::table('tickets')->select('ticket_no')
				->where('area','=',$key->name)->where('ticket_type_id',28)->where('status_id',3)->get()),
			'expired'=> count(DB::table('cust_det')->select('cust_det.account_id')
				->join('jsubs_det','jsubs_det.account_id','=','cust_det.account_id')
				->where('cust_det.address3','=',$key->name)->where('jsubs_det.status','!=','active')->get())
				);
		}
	    $results = array(
	            "sEcho" => 1,
	        "iTotalRecords" => count($data),
	        "iTotalDisplayRecords" => count($data),
	          "aaData"=>$data);

	        return json_encode($results);
	}

}