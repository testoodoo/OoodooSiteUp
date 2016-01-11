<?php

namespace Admin;
use View,Input,SessionDhh,PDF,Mail,Config,DB,Redirect,File,Datatables,JAccountDetail,Response,CusDet,Api,App;

class SessionController extends \BaseController {

	
	public function index(){

		 $data['from_date']=NULL;
         $data['to_date']=NULL;
         $data['usages']=NULL;
         $data['bytes_up']=NULL;
         $data['bytes_down']=NULL;
         $data['bytes_total']=NULL;
         $data['account_id']=NULL;

		return View::make('admin.session.index',$data);		
	}


	public function show(){

		$account_id = Input::get('account_id');
		$from = Input::get('from_date');
		$to = Input::get('to_date');
		$from_date = date("Y-m-d H:i:s",strtotime($from));
		$to_date = date("Y-m-d H:i:s",strtotime($to));
		$to_date = date('Y-m-d H:i:s', strtotime($to_date . ' + 1 day'));

		
		$date_diff= strtotime($to_date) - strtotime($from_date);
		$count = $date_diff/(60 * 60 * 24)+1;

		$date=$from_date;
		$i=0;
		while ( $i <= $count) {
        	$days[] = date ("Y-m-d 00:00:00", strtotime("+1 day", strtotime($date)));
        	$date = date ("Y-m-d 00:00:00", strtotime("+1 day", strtotime($date)));
        	$to_map = date('Y-m-d 00:00:00', strtotime($date . ' + 1 day'));
        	$bytes=SessionDhh::where('account_id','=',$account_id)->whereBetween('start_time',[$date,$to_map])->sum('bytes_total');
        	if ($bytes) {
        		$map_date[$i]=$date;
        		$map_bytes[$i]=SessionDhh::data_usage_in_gb($bytes);
        	}else{
        		$map_date[$i]=$date;
        		$map_bytes[$i]=SessionDhh::data_usage_in_gb($bytes);
        	}
        $i++;
		}
 		$data['bytes']=$map_bytes;
 		$data['date']=$map_date;
		// default dates set for conditions
		if ($from_date!='1970-01-01 00:00:00' && $to_date!='1970-01-02 00:00:00'){
			$data['usages'] = SessionDhh::orderBy('session_id','desc')
		                    ->where('account_id','=',$account_id)
							->whereBetween('start_time',[$from_date,$to_date])
							->paginate(15);

			$bytes_up=SessionDhh::where('account_id','=',$account_id)->whereBetween('start_time',[$from_date,$to_date])->sum('bytes_up');
			$bytes_down=SessionDhh::where('account_id','=',$account_id)->whereBetween('start_time',[$from_date,$to_date])->sum('bytes_down');
			$bytes_total=SessionDhh::where('account_id','=',$account_id)->whereBetween('start_time',[$from_date,$to_date])->sum('bytes_total');
			$data['bytes_up'] =SessionDhh::data_usage_in_gb($bytes_up); 
			$data['bytes_down'] =SessionDhh::data_usage_in_gb($bytes_down); 
			$data['bytes_total'] = SessionDhh::data_usage_in_gb($bytes_total);
			//var_dump($account_id);die;
        
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['account_id']=$account_id;
        	
			}
			
		    $data['sessions'] = SessionDhh::orderBy('session_id','desc')
		                    ->where('account_id','=',$account_id)
							->whereBetween('start_time',[$from_date,$to_date])
							->get();
		    $pdfTemplate = View::make('admin.session.session_pdf', $data)->render();
			$pdf = App::make('dompdf');
			$pdf->loadHTML($pdfTemplate);

			if(Input::get('mail')=="mail"){
				$user=CusDet::where('account_id',$account_id)->first();
				
				if(count($user)!=0){	
					Mail::send('admin.session.mail_pdf', $data, function($message) use($pdf,$data,$user)
						{
						    $message->from('info@oodoo.co.in','Session History');

						    $message->to($user->email)->subject('Session History');

						    $message->attachData($pdf->output(), "Session History.pdf");
						});
				return Redirect::back()->with('success','sent successfully');
				}
			}
            if(count($data['usages'])) {
	       		   return View::make('admin.session.index',$data);
                }else{
       		    	return Redirect::back()->with('failure','your account_id not found');	
            }
	}

	public function sessionHistory(){
		$account_id=Input::get('account_id');
		$session= SessionDhh::select('session_id','ip_address','mac_address',
							'start_time','stop_time','bytes_down','bytes_up','bytes_total')
							->where('account_id','=',$account_id)->orderBy('start_time','desc');
		 $session_history = Datatables::of($session)->make();
		 
		return $session_history;		
	}

	public function postSessionLogs(){
    	$account_id = Input::get('account_id');
    	$account=CusDet::where('account_id','=',$account_id)->get()->first();
    	if($account){
	    		$jaccount=JAccountDetail::where('account_id','=',$account->account_id)->get()->first();
	    		$logs=Api::japi_user_logs($jaccount->jaccount_no,0,100);
			
			return $logs;

		}
		return Response::json(array('found' => "false"));
    }
    
    public function sessionLogs(){
    	return View::make('admin.session.session_log');	
    }


}