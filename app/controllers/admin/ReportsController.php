<?php
namespace Admin;
use View,Input,CusDet,Ticket,DB,TicketDet,FeasibleDet,Bill,DateTime,PaymentTransaction,PaymentMap,Response,Employee,ActiveSession,Jsubs,NewCustomer;

class ReportsController extends \BaseController {

	
	public function Reports() {
		$data['for_month'] = Bill::distinct()->get(array('for_month'));

		$date=date("Y-m-d");
        $plan_start_day =date("d",strtotime($date));
		

		$day =date("Y-m-d 00:00:00", strtotime("-1 day"));
		$lastweek=date("Y-m-d 00:00:00", strtotime("-7 day"));
		$lastmonth=date("Y-m-d 00:00:00", strtotime("-10 month"));
		
		$for_month=date("M-y");
		$second_month=date("M-y", strtotime("-1 month"));
		$third_month=date("M-y", strtotime("-2 month"));

		$data['day'] = $day;
		$data['lastweek']=$lastweek;

		$one = date('Y-m-d');
		$two =date("Y-m-d", strtotime("-1 day"));
		$three =date("Y-m-d", strtotime("-2 day"));
		$four =date("Y-m-d", strtotime("-3 day"));
		$five =date("Y-m-d", strtotime("-4 day"));
		$six =date("Y-m-d", strtotime("-5 day"));
		$seven =date("Y-m-d", strtotime("-6 day"));


		$data['seven_date']=array($one,$two,$three,$four,$five,$six,$seven);


		$data['first_month']=$for_month;
		$data['second_month']=$second_month;
		$data['third_month']=$third_month;

		$from = Input::get('from_date');
		$to = Input::get('to_date');
		$from_date = date("Y-m-d H:i:s",strtotime($from));
		$to_date = date("Y-m-d H:i:s",strtotime($to));
		$to_date = date('Y-m-d H:i:s', strtotime($to_date . ' + 1 day'));
		
		if(!is_null($from)){
			$data['feasible']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->distinct()->get(array('area'));
			$data['fiber']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->sum('fiber');
			$data['ethernet']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->sum('ethernet');
			$data['hut_boxes']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->sum('hut_boxes');
			$data['splicing']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->sum('splicing');
			$data['configuration']=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->sum('configuration');

			$data['cust_process']=FeasibleDet::distinct()->whereBetween('feasible_date',[$from_date,$to_date])->get(array('feasible_date'));
        	$data['cust_finish']=CusDet::distinct()->whereBetween('created_at',[$from_date,$to_date])->get(array('created_at'));

			$data['from_date']=$from_date;
			$data['to_date']=$to_date;
		}else{
			$data['feasible']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->distinct()->get(array('area'));
			$data['fiber']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->sum('fiber');
			$data['ethernet']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->sum('ethernet');
			$data['hut_boxes']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->sum('hut_boxes');
			$data['splicing']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->sum('splicing');
			$data['configuration']=FeasibleDet::whereBetween('feasible_date',[$lastweek,$day])->sum('configuration');
			$data['from_date']=NULL;
			$data['to_date']=NULL;
		}
			$data['feasible_1']=FeasibleDet::distinct()->get(array('area'));
			$data['fiber_1']=FeasibleDet::sum('fiber');
			$data['ethernet_1']=FeasibleDet::sum('ethernet');
			$data['hut_boxes_1']=FeasibleDet::sum('hut_boxes');
			$data['splicing_1']=FeasibleDet::sum('splicing');
			$data['configuration_1']=FeasibleDet::sum('configuration');

		$data['not_paid']=Bill::where('for_month','=',$for_month)->where('status','=','not_paid')->get();
		$data['paid']=Bill::where('for_month','=',$for_month)->where('status','=','paid')->get();
		$data['partially_paid']=Bill::where('for_month','=',$for_month)->where('status','=','partially_paid')->get();

		$data['not_paid_amt']=Bill::where('for_month','=',$for_month)->where('status','=','not_paid')->sum('amount_paid');
		$data['paid_amt']=Bill::where('for_month','=',$for_month)->where('status','=','paid')->sum('amount_paid');
		$data['partially_paid_amt']=Bill::where('for_month','=',$for_month)->where('status','=','partially_paid')->sum('amount_paid');
		
        //var_dump($date3);die;

		$data['tickets']=TicketDet::all();

		$data['today']=TicketDet::whereBetween('ticket_date',[$lastweek,$day])->distinct()->get(array('ticket_type'));

		$data['new_comp']=Ticket::whereBetween('created_at',[$lastweek,$day])->where('ticket_type_id','=','1')->get();
		$data['tech_comp']=Ticket::whereBetween('created_at',[$lastweek,$day])->where('ticket_type_id','=','28')->get();
		$data['bill_comp']=Ticket::whereBetween('created_at',[$lastweek,$day])->where('ticket_type_id','=','29')->get();

		$data['comp_till']=TicketDet::distinct()->get(array('ticket_type'));

		$data['new_comp_till']=Ticket::where('ticket_type_id','=','1')->get();
		$data['tech_comp_till']=Ticket::where('ticket_type_id','=','28')->get();
		$data['bill_comp_till']=Ticket::where('ticket_type_id','=','29')->get();
		//var_dump(DB::table('feasible_details')->where('area','Sholinganallur')->sum('ethernet'));die;

        $data['pending']=PaymentMap::where('for_month','=',$for_month)->where('status','=','pending')->first();
        $data['success']=PaymentMap::where('for_month','=',$for_month)->where('status','=','success')->first();
        $data['failure']=PaymentMap::where('for_month','=',$for_month)->where('status','=','failure')->first();
        $data['failed']=PaymentMap::where('for_month','=',$for_month)->where('status','=','failed')->first();
        $data['cancelled']=PaymentMap::where('for_month','=',$for_month)->where('status','=','cancelled')->first();

      	$data['card']=PaymentMap::where('for_month','=',$for_month)->sum('card_amt');
        $data['cheque']=PaymentMap::where('for_month','=',$for_month)->sum('cheque_amt');
        $data['offline']=PaymentMap::where('for_month','=',$for_month)->sum('cash_offline_amt');
        $data['anpay']=PaymentMap::where('for_month','=',$for_month)->sum('cash_online_anpay_amt');
        $data['acpay']=PaymentMap::where('for_month','=',$for_month)->sum('cash_online_acpay_amt');

        $data['pay_map']=PaymentMap::all();

     

        $data['many']=NULL;

		return View::make('admin.dashboard.reports',$data);
	}

	public function Report()
	{
		$from = Input::get('from');
		$to = Input::get('to');
		$from_date = date("Y-m-d H:i:s",strtotime($from));
		$to_date = date("Y-m-d H:i:s",strtotime($to));
		$to_date = date('Y-m-d H:i:s', strtotime($to_date . ' + 1 day'));
		$areas=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->distinct()->get(array('area'));
		foreach ($areas as $key) {
            $fiber[] =[$key->area,FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('ethernet')];
		}
		
		foreach($areas as $key){
			$splicing=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('splicing');
			$ethernet=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('ethernet');
			$hut_boxes=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('hut_boxes');
			$configuration=FeasibleDet::whereBetween('feasible_date',[$from_date,$to_date])->where('area',$key->area)->sum('configuration');
        }
		$response = array(
						'found' => "true",
						'fiber' => $fiber,
					);
			return Response::json($response);
		//echo json_encode($sum);
	}

	public function ReportTicket()
	{
		$from = Input::get('from');
		$to = Input::get('to');
		$from_date = date("Y-m-d H:i:s",strtotime($from));
		$to_date = date("Y-m-d H:i:s",strtotime($to));
		$to_date = date('Y-m-d H:i:s', strtotime($to_date . ' + 1 day'));

		$new=Ticket::where('ticket_type_id','=','1')->whereBetween('created_at',[$from_date,$to_date])->get();
		$tech=Ticket::where('ticket_type_id','=','28')->whereBetween('created_at',[$from_date,$to_date])->get();
		$bill=Ticket::where('ticket_type_id','=','29')->whereBetween('created_at',[$from_date,$to_date])->get();

		$tickets=TicketDet::distinct()->get(array('ticket_type'));

		if(count($tickets)!=0){
			foreach ($tickets as $key => $value) {
				$open[$value->ticket_type]=TicketDet::where("ticket_type",$value->ticket_type)->whereBetween('ticket_date',[$from_date,$to_date])->sum('open');
				$close[$value->ticket_type]=TicketDet::where("ticket_type",$value->ticket_type)->whereBetween('ticket_date',[$from_date,$to_date])->sum('close');
				$processing[$value->ticket_type]=TicketDet::where("ticket_type",$value->ticket_type)->whereBetween('ticket_date',[$from_date,$to_date])->sum('processing');
				$invaild[$value->ticket_type]=TicketDet::where("ticket_type",$value->ticket_type)->whereBetween('ticket_date',[$from_date,$to_date])->sum('invaild');
			}
		}else{
				$open=NULL;
				$close=NULL;
				$processing=NULL;
				$invaild=NULL;
		}

		$from_dat = date("Y-m-d",strtotime($from));
		$to_dat = date('Y-m-d', strtotime($to_date . ' + 1 day'));

		$response = array(
						'found' => "true",
						'new' => count($new),
						'tech' => count($tech),
						'bill' => count($bill),
						'from' => $from_dat,
						'to' => $to_dat,
						'open' => $open,
						'close' =>$close,
						'processing' => $processing,
						'invaild' => $invaild,
					);
			return Response::json($response);
		//echo json_encode($sum);
	}

	public function ReportBill()
	{
		$for_month = Input::get('for_month');
		$not_paid=Bill::where('for_month','=',$for_month)->where('status','=','not_paid')->get();
		$paid=Bill::where('for_month','=',$for_month)->where('status','=','paid')->get();
		$partially_paid=Bill::where('for_month','=',$for_month)->where('status','=','partially_paid')->get();

		$not_paid_amt=Bill::where('for_month','=',$for_month)->where('status','=','not_paid')->sum('amount_paid');
		$paid_amt=Bill::where('for_month','=',$for_month)->where('status','=','paid')->sum('amount_paid');
		$partially_paid_amt=Bill::where('for_month','=',$for_month)->where('status','=','partially_paid')->sum('amount_paid');
		$response = array(
						'found' => "true",
						'not_paid' => count($not_paid),
						'paid' => count($paid),
						'partially_paid' => count($partially_paid),
						'not_paid_amt' => $not_paid_amt,
						'paid_amt' => $paid_amt,
						'partially_paid_amt' => $partially_paid_amt,
					);
			return Response::json($response);
		//echo json_encode($sum);
	}

	public function ReportPayment()
	{
		$for_month = Input::get('for_month');
		$pending=PaymentMap::where('for_month','=',$for_month)->where('status','=','pending')->first();
        $success=PaymentMap::where('for_month','=',$for_month)->where('status','=','success')->first();
        $failure=PaymentMap::where('for_month','=',$for_month)->where('status','=','failure')->first();
        $failed=PaymentMap::where('for_month','=',$for_month)->where('status','=','failed')->first();
        $cancelled=PaymentMap::where('for_month','=',$for_month)->where('status','=','cancelled')->first();

        $pending_amt=$pending->card_amt+$pending->cheque_amt+$pending->cash_offline_amt+$pending->cash_online_anpay_amt+$pending->cash_online_acpay_amt;
       	$success_amt=$success->card_amt+$success->cheque_amt+$success->cash_offline_amt+$success->cash_online_anpay_amt+$success->cash_online_acpay_amt;
        $failure_amt=$failure->card_amt+$failure->cheque_amt+$failure->cash_offline_amt+$failure->cash_online_anpay_amt+$failure->cash_online_acpay_amt;
        $failed_amt=$failed->card_amt+$failed->cheque_amt+$failed->cash_offline_amt+$failed->cash_online_anpay_amt+$failed->cash_online_acpay_amt;
        $cancelled_amt=$cancelled->card_amt+$cancelled->cheque_amt+$cancelled->cash_offline_amt+$cancelled->cash_online_anpay_amt+$cancelled->cash_online_acpay_amt;

      	$card=PaymentMap::where('for_month','=',$for_month)->sum('card_amt');
        $cheque=PaymentMap::where('for_month','=',$for_month)->sum('cheque_amt');
        $offline=PaymentMap::where('for_month','=',$for_month)->sum('cash_offline_amt');
        $anpay=PaymentMap::where('for_month','=',$for_month)->sum('cash_online_anpay_amt');
        $acpay=PaymentMap::where('for_month','=',$for_month)->sum('cash_online_acpay_amt');
		$response = array(
						'found' => "true",
						'pending' => array("t"=>$pending->cheque,"a"=>$pending->card,"m"=>$pending->cash,"i"=>$pending->cash_online,"l"=>$pending->cash_offline,"n"=>$pending->cash_online_anpay,"a"=>$pending->cash_online_acpay),
						'success' => array("t"=>$success->cheque,"a"=>$success->card,"m"=>$success->cash,"i"=>$success->cash_online,"l"=>$success->cash_offline,"n"=>$success->cash_online_anpay,"a"=>$success->cash_online_acpay),
						'failure' => array("t"=>$failure->cheque,"a"=>$failure->card,"m"=>$pending->cash,"i"=>$failure->cash_online,"l"=>$failure->cash_offline,"n"=>$failure->cash_online_anpay,"a"=>$failure->cash_online_acpay),
						'failed' => array("t"=>$failed->cheque,"a"=>$failed->card,"m"=>$failed->cash,"i"=>$failed->cash_online,"l"=>$failed->cash_offline,"n"=>$failed->cash_online_anpay,"a"=>$failed->cash_online_acpay),
						'cancelled' => array("t"=>$cancelled->cheque,"a"=>$cancelled->card,"m"=>$cancelled->cash,"i"=>$cancelled->cash_online,"l"=>$cancelled->cash_offline,"n"=>$cancelled->cash_online_anpay,"a"=>$cancelled->cash_online_acpay),
						'amount' => array("t"=>$pending_amt,"a"=>$success_amt,"m"=>$failure_amt,"i"=>$failed_amt,"l"=>$cancelled_amt),
						'cash' => array("t"=>$card,"a"=>$cheque,"m"=>$offline,"i"=>$anpay,"l"=>$acpay),
					);
			return Response::json($response);
		//echo json_encode($sum);
	}

	public function TicketReports()
	{
		return View::make('admin.reports.ticket_details');
	}

	public function TicketReportsAjax()
	{
			$from = Input::get('from');
	        $to = Input::get('to');

	        if((!$from && !$to)||($from=="undefined" && $to=="undefined")){
	            $to_date = date("Y-m-d 00:00:00");
	            $from_date = date("Y-m-d 00:00:00",strtotime("-2 month",strtotime($to_date)));
	        }else{
	            $from_date = date("Y-m-d 00:00:00",strtotime($from));
	            $to_date = date("Y-m-d 00:00:00",strtotime($to));
	        }

	        $assigned_to=Ticket::whereBetween('created_at',[$from_date,$to_date])->distinct()->get(array('assigned_to'));
	        $assigned_by=Ticket::whereBetween('created_at',[$from_date,$to_date])->distinct()->get(array('assigned_by'));
	        foreach ($assigned_by as $key) {
	        	if($key->assigned_by!=''){
	        		$assign_by[]=$key->assigned_by;
	        	}
	        }
	        if(count($assigned_by)==0){
	        	$assign_by[]=NULL;
	        }
	        foreach ($assigned_to as $key) {
	        	if($key->assigned_to!=''){
		        	$assign_to[]=$key->assigned_to;
	        	}
	        }
	        if(count($assigned_to)==0){
	        	$assign_to[]=NULL;
	        }
	        $assign = array_merge_recursive($assign_to, $assign_by);
	        
	        $assign_unique=array_unique($assign);

	        if(count($assign_unique)!=0){
	        
	        foreach ($assign_unique as $key) {
	                $data[]=array('employee_id'=>$key,
	                    'assign_by'=>Employee::where('employee_identity',$key)->first()->name,
	                    'by_open'=>count(Ticket::where('assigned_by',$key)->whereBetween('created_at',[$from_date,$to_date])->where('status_id',3)->get()),
	                    'by_close'=>count(Ticket::where('assigned_by',$key)->whereBetween('created_at',[$from_date,$to_date])->where('status_id',4)->get()),
	                    'assign_to'=>Employee::where('employee_identity',$key)->first()->name,
	                    'to_open'=>count(Ticket::where('assigned_to',$key)->whereBetween('created_at',[$from_date,$to_date])->where('status_id',3)->get()),
	                    'to_close'=>count(Ticket::where('assigned_to',$key)->whereBetween('created_at',[$from_date,$to_date])->where('status_id',4)->get()));
	        	}
	         
	    }else{
	            $data = array(array('employee_id'=>'Data Not available','assign_by'=>'NiLL','by_open'=>'NiLL',
	                                'by_close'=>'NiLL','assign_to'=>'NiLL','to_open'=>'NiLL','to_close'=>'NiLL'));
	    }
	    $results = array(
	            "sEcho" => 1,
	        "iTotalRecords" => count($data),
	        "iTotalDisplayRecords" => count($data),
	          "aaData"=>$data);

	        return json_encode($results);

	    }

	public function AccountReportDetails()
	{
		$data['for_month'] =Bill::distinct()->get(array('for_month'));

		$for_month = Input::get('for_month');

		$current_month=date('M-y');

		if(count($for_month)!=0){
			$data['bills']=Bill::where('for_month',$for_month)->get();

			$data['closed']= DB::table('plan_det')->Join('bill_det','plan_det.account_id','=','bill_det.account_id')
			->where('bill_det.for_month',$for_month)->where('bill_det.status','=','not_paid')->where('plan_det.plan_code','=',1460)->get();
			
			$data['acc_suspend']= DB::table('cust_det')->select('cust_det.crf_no','cust_det.account_id','cust_det.first_name',
			'cust_det.email','cust_det.phone','cust_det.address1','cust_det.address2','cust_det.address3')
			->Join('bill_det','bill_det.account_id','=','cust_det.account_id')
			->where('bill_det.for_month',$for_month)->where('bill_det.status','=','not_paid')->get();

			$data['active']= DB::table('cust_det')->select('cust_det.crf_no','cust_det.account_id','cust_det.first_name',
			'cust_det.email','cust_det.phone','cust_det.address1','cust_det.address2','cust_det.address3')
			->Join('bill_det','bill_det.account_id','=','cust_det.account_id')
			->where('bill_det.for_month',$for_month)->where('bill_det.status','!=','not_paid')->get();

			$data['for_mon']=$for_month;

		}else{
			
			$data['bills']=Bill::where('for_month',$current_month)->get();

			$data['closed']= DB::table('plan_det')->Join('bill_det','plan_det.account_id','=','bill_det.account_id')
			->where('bill_det.for_month',$current_month)->where('bill_det.status','=','not_paid')->where('plan_det.plan_code','=',1460)->get();
			
			$data['acc_suspend']= DB::table('cust_det')->select('cust_det.crf_no','cust_det.account_id','cust_det.first_name',
			'cust_det.email','cust_det.phone','cust_det.address1','cust_det.address2','cust_det.address3')
			->Join('bill_det','bill_det.account_id','=','cust_det.account_id')
			->where('bill_det.for_month',$current_month)->where('bill_det.status','=','not_paid')->get();

			$data['active']= DB::table('cust_det')->select('cust_det.crf_no','cust_det.account_id','cust_det.first_name',
			'cust_det.email','cust_det.phone','cust_det.address1','cust_det.address2','cust_det.address3')
			->Join('bill_det','bill_det.account_id','=','cust_det.account_id')
			->where('bill_det.for_month',$current_month)->where('bill_det.status','!=','not_paid')->get();
		
			$data['for_mon']=$current_month;
		}	


		return View::make('admin.reports.account_details',$data);
	}

	public function AccountAjaxDetails()
	{
		$for_month = Input::get('for_month');
		if(count($for_month)!=0){
			$for_mont=$for_month;
		}else{
			$for_mont=$current_month=date('M-y');
		}

		$days=date('t',strtotime($for_mont));
		$l_year=substr($for_mont,4,6);
		$f_year=substr(date('Y',strtotime($for_mont)),0,2);

		for ($i=1; $i <= $days ; $i++) { 
			$created_at[]=date($f_year.''.$l_year.'-m-'.sprintf("%02s", $i).' 00:00:00',strtotime($for_mont));
		}

		 		foreach ($created_at as $key) {
					$from_date=$key;
					$to_date=date('Y-m-d 00:00:00',strtotime("+1 day",strtotime($key)));
					$total=count(Bill::where('for_month',$for_mont)->whereBetween('created_at',[$from_date,$to_date])->get());
	                $active=count(DB::table('cust_det')->Join('bill_det','bill_det.account_id','=','cust_det.account_id')->whereBetween('cust_det.created_at',[$from_date,$to_date])->where('bill_det.status','!=','not_paid')->where('bill_det.for_month',$for_mont)->get());
	                $suspended=count( DB::table('cust_det')->Join('bill_det','bill_det.account_id','=','cust_det.account_id')->whereBetween('cust_det.created_at',[$from_date,$to_date])->where('bill_det.status','=','not_paid')->where('bill_det.for_month',$for_mont)->get());
	                $closed= count(DB::table('plan_det')->Join('bill_det','plan_det.account_id','=','bill_det.account_id')->whereBetween('plan_det.created_at',[$from_date,$to_date])->where('bill_det.status','=','not_paid')->where('bill_det.for_month',$for_mont)->where('plan_det.plan_code','=',1460)->get());
					$new=count(NewCustomer::whereBetween('created_at',[$from_date,$to_date])->get());

	                $val=$total+$active+$suspended+$closed;

					if($val!=0){
	                $data[]=array('date'=>$key,
	                    'total'=>$total,
	                    'active'=>$active,
	                    'suspended'=>$suspended,
	                    'closed'=>$closed,
	                    'new'=>$new);
					}
	        	}

	    $results = array(
	            "sEcho" => 1,
	        "iTotalRecords" => count($data),
	        "iTotalDisplayRecords" => count($data),
	          "aaData"=>$data);

	        return json_encode($results);

	}

	public function SendReportDetails()
	{
		return View::make('admin.reports.send_reports');
	}



}