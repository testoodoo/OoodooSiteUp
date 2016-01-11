<?php

namespace Admin;
use View,Input,Response,Redirect,Datatables,DB,StockCategory,StockInEmployees,StockOtherEmp,StockOthers;
use Employee,StockInOnu,StockInRouter,StockInSwitch,StockInOlt,StockOutCustomers,StockOtherCust;
class StockReportsController extends \BaseController {


	public function CateGoryReport()
	{
		return View::make('admin.stock_reports.reports_category');
	}


	public function CateGoryReportAjax(){

		$stock=DB::table('stock_category')->select('id','material_name','brand','material_type','material_details')->orderBy('id','desc');
        $stocks = Datatables::of($stock)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/stock_report/stock-report/{{$id}}">
																	<i class="label label-success arrowed">show</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
        return $stocks;

	}

	public function StockReport($id){

		$material=StockCategory::where('id',$id)->first();

		if($material->material_details=="fiber" || $material->material_details=="ethernet" || $material->material_details=="others"){
			$data['material']=$material;
			return View::make('admin.stock_reports.meters_reports',$data);	

		}else if($material->material_details=="onu" || $material->material_details=="olt" || $material->material_details=="router" ||$material->material_details=="switch"){
			$data['material']=$material;
			$data['employees']=Employee::all();
			return View::make('admin.stock_reports.count_reports',$data);		
		}
	}


	public function StockReportAjax(){
		
		$ids=Input::get('id');

		$material=StockCategory::where('id',$ids)->first();

		$type=$material->material_name.'-'.$material->brand;
		
		if($material->material_details=="fiber"){
				$stock=StockInEmployees::select('id','material_brand','total_meter','used','damage','left_over')
									->where('material_brand',$type)
		 							->orderBy('id','desc');
		 							
		return Datatables::of($stock)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/stock_report/stock-report_meter/{{$id}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">show</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
		}else if($material->material_details=='ethernet'){
			$stock=StockInEmployees::select('id','material_brand','total_meter','used','damage','left_over')
									->where('material_brand',$type)
		 							->orderBy('id','desc');
		 		
		return Datatables::of($stock)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/stock_report/stock-report_meter/{{$id}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">show</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
		 							
		}else if($material->material_details=='onu'){

				$stock=StockInOnu::select('id','onu_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('process','@if(DB::table("stock_in_onu")->where("id",$id)->first()->process==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('wait','@if(DB::table("stock_in_onu")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('damage','@if(DB::table("stock_in_onu")->where("id",$id)->first()->damage==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('complete','@if(DB::table("stock_in_onu")->where("id",$id)->first()->complete==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)->make();
		
		}else if($material->material_details=='router'){

				$stock=StockInRouter::select('id','router_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('process','@if(DB::table("stock_in_onu")->where("id",$id)->first()->process==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('wait','@if(DB::table("stock_in_onu")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('damage','@if(DB::table("stock_in_onu")->where("id",$id)->first()->damage==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('complete','@if(DB::table("stock_in_onu")->where("id",$id)->first()->complete==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)->make();
		}else if($material->material_details=='switch'){

				$stock=StockInSwitch::select('id','switch_id','material_brand','srl_no','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('process','@if(DB::table("stock_in_onu")->where("id",$id)->first()->process==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('wait','@if(DB::table("stock_in_onu")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('damage','@if(DB::table("stock_in_onu")->where("id",$id)->first()->damage==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('complete','@if(DB::table("stock_in_onu")->where("id",$id)->first()->complete==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)->make();
		}else if($material->material_details=='olt'){
				
				$stock=StockInOlt::select('id','olt_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('process','@if(DB::table("stock_in_onu")->where("id",$id)->first()->process==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('wait','@if(DB::table("stock_in_onu")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('damage','@if(DB::table("stock_in_onu")->where("id",$id)->first()->damage==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)
											->addColumn('complete','@if(DB::table("stock_in_onu")->where("id",$id)->first()->complete==1)
																	<span class="btn btn-minier btn-success">Yes</span>
																	@else
		 															<span class="btn btn-minier btn-danger">No</span>
																	@endif',false)->make();	
		}else if($material->material_details=='others'){

				$stock=StockOthers::select('id','material_brand','total','used','damage','left_over')
									->where('material_brand',$type)->orderBy('id','desc');
		 		return Datatables::of($stock)->addColumn('show','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/stock_report/stock-report_meter/{{$id}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">show</i>
																</a>&nbsp;&nbsp;
															</div>',false)->make();
		}
	}

	public function StockReportMeter($id){
		$material_type=Input::get('material');
		$types=explode('-',$material_type);

		$material=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();
		if($material->material_details=="fiber"){
			$stock=StockInEmployees::where('drum_no',$id)->where('material_brand',$material_type)->get();
			$stockOut=StockOutCustomers::where('fiber_drum_no',$id)->get();
			$data['material']=$material;
			$data['meters']=$stock;
			$data['stockout']=$stockOut;
			$data['type']="fiber";
			return View::make('admin.stock_reports.meters_employee_reports',$data);
		}else if($material->material_details=="ethernet"){
			$stock=StockInEmployees::where('drum_no',$id)->where('material_brand',$material_type)->get();
			$stockOut=StockOutCustomers::where('ethernet_drum_no',$id)->get();
			$data['material']=$material;
			$data['meters']=$stock;
			$data['stockout']=$stockOut;
			$data['type']="ethernet";
			return View::make('admin.stock_reports.meters_employee_reports',$data);
		}else if($material->material_details=="others"){
			$stock=StockOtherEmp::where('stock_others_id',$id)->where('material_brand',$material_type)->get();
			$stockOut=StockOtherCust::where('stock_others_id',$id)->get();
			$data['material']=$material;
			$data['meters']=$stock;
			$data['stockout']=$stockOut;
			$data['type']="others";
			return View::make('admin.stock_reports.meters_employee_reports',$data);
		}
	}

}