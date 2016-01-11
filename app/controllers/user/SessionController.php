<?php
namespace User;
use Auth, SubsDetail, ActiveSession, PlanCostDetail, SessionDhh, Input, View, BaseController, Plan, Jsubs , JactiveSession,App; 
class SessionController extends BaseController {


	Public function data_usage(){
		$account_id = Auth::user()->get()->account_id;
		$data_total=Auth::user()->get()->data_usage_in_gb();
		$current_plan = Jsubs::where('account_id','=',$account_id)->get();
			
			if(count($current_plan)!=0){
				$data['current_plan'] = $current_plan->first()->plan;
			}else{
				$data['current_plan'] = NULL;
			}

		$data['usage'] = JactiveSession::where('account_id','=',$account_id)->get()->first();
		$plan_code = Plan::where('account_id','=',$account_id)->get()->first()->plan_code;
		$plan_data = PlanCostDetail::where('plan_code','=',$plan_code)->get()->first()->data_gb;
		$data["plan_data"] = $plan_data;
		if($plan_data != 'NA'){
			$data_left = $plan_data-$data_total;
			if($data_left < 0){
				$data['data_left'] = '0'.' GB';
			}else{
				$data['data_left'] = $data_left.' GB';
			}

		}
		else{
			$data['data_left'] = 'NA';
		}
			return View::make('user.sessions.data_usage',$data);
	}


	public function usage(){
		$account_id = Auth::user()->get()->account_id;
		$data['usages'] = SessionDhh::orderBy('sesssion_id','desc')
	                    ->where('account_id','=',$account_id)
						->paginate(20);				
	 return View::make('user.sessions.data_usage',$data);	
	}


	public function session_history(){
		$account_id = Auth::user()->get()->account_id;
		$data['account_id']=$account_id;
		$from = Input::get('from_date');
		$to = Input::get('to_date');
		if($from != NULL && $to != NULL){
			$from_date = date('Y-m-d 00:00:00',strtotime($from));
			$to_date = date('Y-m-d 00:00:00',strtotime($to . "+1 days"));
			$data['usages'] = $usages = SessionDhh::orderBy('session_id','desc')
		                    ->where('account_id','=',$account_id)
		                    ->whereBetween('start_time',[$from_date,$to_date])
		                    ->paginate(20);

		    $fup_bytes_in = SessionDhh::orderBy('session_id','desc')
		                    ->where('account_id','=',$account_id)
		                    ->whereBetween('start_time',[$from_date,$to_date])
		                    ->sum('bytes_up');
		    $data['bytes_down'] = SessionDhh::data_usage_in_gb($fup_bytes_in);

			$fup_bytes_out = SessionDhh::orderBy('session_id','desc')
		                    ->where('account_id','=',$account_id)
		                    ->whereBetween('start_time',[$from_date,$to_date])
		                    ->sum('bytes_down');
		    $data['bytes_up'] = SessionDhh::data_usage_in_gb($fup_bytes_out);

		    $data['bytes_total'] = $data['bytes_down'] + $data['bytes_up'];

			$data['from_date'] = $from_date;
			$data['to_date'] = $to_date;
		}else{
			$data['usages'] = SessionDhh::orderBy('session_id','desc')
									->orWhere('account_id','=',$account_id)
									->paginate(20);
			$date=SessionDhh::orderBy('session_id','desc')->where('account_id','=',$account_id)->first();
			if ($date) {
					$data['from_date']=SessionDhh::orderBy('session_id','desc')->where('account_id','=',$account_id)->first()->start_time;
					$data['to_date']=SessionDhh::orderBy('session_id','asc')->where('account_id','=',$account_id)->first()->start_time;
			}else{
					$data['from_date']="";
					$data['to_date']="";
			}
			$data['bytes_up']=SessionDhh::data_usage_in_gb(SessionDhh::orderBy('session_id','desc')->where('account_id','=',$account_id)->sum('bytes_up'));
			$data['bytes_down']=SessionDhh::data_usage_in_gb(SessionDhh::orderBy('session_id','desc')->where('account_id','=',$account_id)->sum('bytes_down'));
			$data['bytes_total']=$data['bytes_up']+$data['bytes_down'];
		}
		if(Input::get('print')=="print"){
				$data['sessions']=SessionDhh::orderBy('session_id','desc')->orWhere('account_id','=',$account_id)->get(); 
				$pdfTemplate = View::make('admin.session.session_pdf', $data)->render();
   				$pdf = App::make('dompdf');
   				$pdf->loadHTML($pdfTemplate);
   				return $pdf->download($account_id.'-sessions.pdf');
   			}
   			//var_dump($fup_bytes_out);die;
		return View::make('user.sessions.session_usage',$data);
	}

}
