<?php

namespace Admin;
use View,Input,Response,Redirect,Employee,SwitchRouter,PreActivationStatus,DB,Datatables,SwitchRouterId,Auth,StockInFiber,CusDet; 
use StockInEthernet,StockInOnu,StockInRouter,StockInSwitch,StockInEmployees,StockCategory,StockIn,StockOutCustomers,StockOthers,StockOtherCust,StockOtherEmp;

class SwitchRouterController extends \BaseController {

	public function Category(){
		return View::make('admin.switch_routers.category');
	}

	public function UpdateStockDet(){
		return View::make('admin.switch_routers.stock_update_det');
	}

	public function UpdateStockDetAjax(){
		$fiber_stocks=StockInEmployees::select('id','employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
							->where('material_brand',$type)
							->groupBy('id')
 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
 							->orderBy('id','desc')->get();
		 	foreach ($fiber_stocks as $key) {
		 			$check[]=$key->id;
		 	}
		 	if(count($fiber_stocks)==0){
 				$check[]=null;
 			}
 		$fiber_stock=StockInEmployees::select('employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
							->whereIn('id',$check)
							->where('material_brand',$type)
							->groupBy('employee_identity')
 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
 							->orderBy('employee_identity','desc');
		 							
		$ethernet_stocks=StockInEmployees::select('id','employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->where('material_brand',$type)
									->groupBy('id')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('id','desc')->get();
		 		
				 	foreach ($ethernet_stocks as $key) {
				 			$check[]=$key->id;
				 	}
				 	if(count($ethernet_stocks)==0){
		 				$check[]=null;
		 			}
		 $ethernet_stock=StockInEmployees::select('employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->where('material_brand',$type)
									->whereIn('id',$check)
									->groupBy('employee_identity')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('employee_identity','desc');
		 							
		 							

				$stock=StockInOnu::select('receiver','material_brand',DB::raw('sum(complete) as total'),DB::raw('sum() as sub_total'))->where('complete',0)->orderBy('id','desc');
		

				$stock=StockInRouter::select('id','router_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');

				$stock=StockInSwitch::select('id','switch_id','material_brand','srl_no','sender','receiver')->where('complete',0)->orderBy('id','desc');
				
				$stock=StockInOlt::select('id','olt_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');

				$other_stocks=StockOtherEmp::select('id','material_brand',DB::raw('sum(total) as total'),DB::raw('sum(damage+left_over+used) as sub_total'))
										->where('material_brand',$type)
										->groupBy('id')
			 							->havingRaw('sum(total) > sum(used+damage+left_over)')
			 							->get();
			 	foreach ($other_stocks as $key) {
		 			$check[]=$key->id;
		 		}
		 		if(count($other_stocks)==0){
		 			$check[]=null;
		 		}

			 	$other_stock=StockOtherEmp::select('employee_identity','material_brand',DB::raw('sum(total) as total'),DB::raw('sum(damage+left_over+used) as sub_total'))
										->whereIn('id',$check)
										->where('material_brand',$type)
										->groupBy('employee_identity')
			 							->havingRaw('sum(total) > sum(used+damage+left_over)')
			 							->orderBy('employee_identity','desc');
			 							
		 		return Datatables::of($stock)->make();
	}

	public function createCategory(){
		$cate=StockCategory::all();
		foreach ($cate as $key) {
			$brand[]=$key->material_name.'-'.$key->brand;
		}
		if(count($cate)==0){
			$brand[]="null";
		}

		$new_brand[]=Input::get('name').'-'.Input::get('brand');
		if(in_array($brand,$new_brand)){
			
			$category=new StockCategory();
			$category->material_name=Input::get('name');
			$category->brand=Input::get('brand');
			$category->material_type=Input::get('material_type');
			$material_details=Input::get('material_details');
			$category->material_details=$material_details;
			$category->date=Input::get('date');
			$category->save();

			return View::make('admin.switch_routers.category');
		}else{
			return Redirect::back()->with('failure','Stock Category Already Existed');
		}
	}

	public function showCategory(){
		return View::make('admin.switch_routers.show_category');

	}

	
	public function StockIn(){
		$data['stocks'] =StockCategory::all();
		return View::make('admin.switch_routers.stock_incoming',$data);
	}

	public function CreateStockIn(){
		$material_type=Input::get('material_type');
		$type=Input::get('type');
		$final_count=Input::get('final_count');
		$final_meter=Input::get('final_meter');
		$date=Input::get('date');
		
		$drum_no=Input::get('meter_drum_no');
		$start_meter=Input::get('from_meter');
		$end_meter=Input::get('to_meter');
		$total_meter=Input::get('total_meter');

		$srl=Input::get('srl_no');
		$mac=Input::get('mac_address');

		$stock=new StockIn();
		$stock->material_type=Input::get('type');
		$stock->material_brand=Input::get('material_type');
		$stock->total_meter=$final_meter;
		$stock->total_count=$final_count;
		$stock->date=$date;
		$stock->save();

		$types=explode('-',$material_type);

		$material=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();

		if($material->material_details=='fiber'){
			for($i=0;$i< count($drum_no) ;$i++) {
				$fiber=new StockInFiber();
				$fiber->material_brand=Input::get('material_type');
				$fiber->start_meter=$start_meter[$i];
				$fiber->end_meter=$end_meter[$i];
				$fiber->total_meter=$total_meter[$i];
				$fiber->date=Input::get('date');
				$fiber->save();
				$fiber->drum_no=$fiber->id;
				$fiber->save();
			}
		}else if($material->material_details=='ethernet'){
			for($i=0;$i< count($drum_no) ;$i++) {
				$ethernet=new StockInEthernet();
				$ethernet->material_brand=Input::get('material_type');
				$ethernet->start_meter=$start_meter[$i];
				$ethernet->end_meter=$end_meter[$i];
				$ethernet->total_meter=$total_meter[$i];
				$ethernet->date=Input::get('date');
				$ethernet->save();
				$ethernet->drum_no=$ethernet->id;
				$ethernet->save();
			}
		}else if($material->material_details=='onu'){
			for($i=0;$i< count($srl) ;$i++) {
				$onu=new StockInOnu();
				$onu->material_brand=Input::get('material_brand');
				$onu->srl_no=$srl[$i];
				$onu->mac_address=$mac[$i];
				$onu->date=Input::get('date');
				$onu->save();
				$onu->onu_id='OFONU'.$onu->id;
				$oun->save();
			}
		}else if($material->material_details=='router'){
			for($i=0;$i< count($srl) ;$i++) {
				$router=new StockInRouter();
				$router->material_brand=Input::get('material_brand');
				$router->srl_no=$srl[$i];
				$router->mac_address=$mac[$i];
				$router->date=Input::get('date');
				$router->save();
				$router->router_id='OFROUTER'.$router->id;
				$router->save();
			}
		}else if($material->material_details=='switch'){
			for($i=0;$i< count($srl) ;$i++) {
				$switch=new StockInSwitch();
				$switch->material_brand=Input::get('material_brand');
				$switch->srl_no=$srl[$i];
				$switch->date=Input::get('date');
				$switch->save();
				$switch->router_id='OFSWITCH'.$switch->id;
				$switch->save();
			}
		}else if($material->material_details=='olt'){
			for($i=0;$i< count($srl) ;$i++) {
				$olt=new StockInOlt();
				$olt->material_brand=Input::get('material_brand');
				$olt->srl_no=$srl[$i];
				$olt->mac_address=$mac[$i];
				$olt->date=Input::get('date');
				$olt->save();
				$olt->olt_id='OFSWITCH'.$olt->id;
				$olt->save();
			}
		}else if($material->material_details=='others'){
				$others=new StockOthers();
				$others->material_brand=Input::get('material_type');
				$others->date=Input::get('date');
				$others->total=$final_count;
				$others->save();
		}

		return Redirect::to('/admin/switch_router/stock_in')
				->with('success','Added Succesfully');
	}

	public function StockOut(){
		$data['stocks'] =StockCategory::all();
		$data['employees'] =Employee::all();
		return View::make('admin.switch_routers.stock_outgoing',$data);

	}

	public function CreateStockOut(){

		$material_type=Input::get('material_type');
		$type=Input::get('type');
		$final_count=Input::get('final_count');
		$final_meter=Input::get('final_meter');
		$date=Input::get('date');
		
		$drum_no=Input::get('drum_no');
		$start_meter=Input::get('from_meter');
		$end_meter=Input::get('to_meter');
		$total_meter=Input::get('total_meter');

		$id=Input::get('c_id');
		$srl=Input::get('srl_no');
		$mac=Input::get('mac_address');
		$employee=Input::get('employee');
		$types=explode('-',$material_type);

		$final_count1=Input::get('final_count1');
		
		$material=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();

		if($material->material_details=='fiber'){
			for($i=0;$i< count($drum_no) ;$i++) {
				$fiber=new StockInEmployees();
				$fiber->material_brand=$material_type;
				$fiber->drum_no=$drum_no[$i];
				$fiber->start_meter=$start_meter[$i];
				$fiber->end_meter=$end_meter[$i];
				$fiber->total_meter=$total_meter[$i];
				$fiber->employee_identity=$employee;
				$fiber->date=Input::get('date');
				$fiber->save();
			}
		}else if($material->material_details=='ethernet'){
			for($i=0;$i< count($drum_no) ;$i++) {
				$ethernet=new StockInEmployees();
				$ethernet->material_brand=$material_type;
				$ethernet->drum_no=$drum_no[$i];
				$ethernet->start_meter=$start_meter[$i];
				$ethernet->end_meter=$end_meter[$i];
				$ethernet->total_meter=$total_meter[$i];
				$ethernet->employee_identity=$employee;
				$ethernet->date=Input::get('date');
				$ethernet->save();
			}
		}else if($material->material_details=='onu'){
			for($i=0;$i< count($srl) ;$i++) {
				$onu=StockInOnu::where('srl_no',$srl_no[$i])->first();
				$onu->sender=Auth::employee()->get()->employee_identity;
				$onu->receiver=$employee;
				$onu->process=1;
				$onu->save();
			}
		}else if($material->material_details=='router'){
			for($i=0;$i< count($srl) ;$i++) {
				$router=StockInRouter::where('srl_no',$srl_no[$i])->first();
				$router->sender=Auth::employee()->get()->employee_identity;
				$router->receiver=$employee;
				$router->process=1;
				$router->save();
			}
		}else if($material->material_details=='switch'){
			for($i=0;$i< count($srl) ;$i++) {
				$switch=StockInSwitch::where('srl_no',$srl_no[$i])->first();
				$switch->sender=Auth::employee()->get()->employee_identity;
				$switch->receiver=$employee;
				$switch->process=1;
				$switch->save();
				
			}
		}else if($material->material_details=='olt'){
			for($i=0;$i< count($srl) ;$i++) {
				$olt=StockInOlt::where('srl_no',$srl_no[$i])->first();
				$olt->sender=Auth::employee()->get()->employee_identity;
				$olt->receiver=$employee;
				$olt->process=1;
				$olt->save();
				
			}
		}else if($material->material_details=='others'){
				$others=new StockOtherEmp();
				$others->material_brand=$material_type;
				$others->date=Input::get('date');
				$others->total=$final_count1;
				$others->employee_identity=$employee;
				$others->save();
		}

		return Redirect::to('/admin/switch_router/stock_out')
				->with('success','Added Succesfully');

	}

	public function CheckStock(){

		$material_type=Input::get('material');
		$type=Input::get('type');
		$start_meter=Input::get('start');
		$end_meter=Input::get('end');
		$drum_no=Input::get('drum_no');
		$srl_no=Input::get('srl_no');
		$final_c=Input::get('final_c');

		$types=explode('-',$material_type);

		$material=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();

		if($material->material_details=="fiber"){
			$key=StockInFiber::where('drum_no',$drum_no)->first();
			if(count($key)!=0){
				if($key->total_meter > $key->usage+$key->damage+$key->left_over){
						$meter=$key->start_meter-$key->end_meter;
						if($meter < 0){
							$meters=(-1*$meter);
						}
						$stock=StockInFiber::where('drum_no',$drum_no)->where('start_meter','<=',$start_meter)
							->where('end_meter','>=',$end_meter)->first();
						$status="true";
						$range=$meters;
				}else{
					$range="null";
					$status="false";
					$stock="Meter Not In Range !!!!";
				}
			}else{
				$range="null";
				$status="false";
				$stock="Drum No Not Available !!!!";
			}
		}else if($material->material_details=='ethernet'){
			$key=StockInEthernet::where('drum_no',$drum_no)->first();
			if(count($key)!=0){
				if($key->total_meter > $key->usage+$key->damage+$key->left_over){
						$meter=$key->start_meter-$key->end_meter;
						if($meter < 0){
							$meters=(-1*$meter);
						}
						$stock=StockInEthernet::where('drum_no',$drum_no)->where('start_meter','<=',$start_meter)
								->where('end_meter','>=',$end_meter)->first();
						$status="true";
						$range=$meters;
				}else{
					$range="null";
					$status="false";
					$stock="Meter Not In Range !!!!";
				}
			}else{
				$range="null";
				$status="false";
				$stock="Drum No Not Available !!!!";
			}
		}else if($material->material_details=='onu'){
				$stock=StockInOnu::where('srl_no',$srl_no)->first();
				if(count($stock)!=0){
					$status="true";
					$range="null";
				}else{
					$range="null";
					$status="false";
					$stock="Not Available !!!!";
				}
		}else if($material->material_details=='router'){
				$stock=StockInRouter::where('srl_no',$srl_no)->first();
				if(count($stock)!=0){
					$status="true";
					$range="null";
				}else{
					$range="null";
					$status="false";
					$stock="Not Available !!!!";
				}
		}else if($material->material_details=='switch'){
				$stock=StockInSwitch::where('srl_no',$srl_no)->first();
				if(count($stock)!=0){
					$status="true";
					$range="null";
				}else{
					$range="null";
					$status="false";
					$stock="Not Available !!!!";
				}
		}else if($material->material_details=='olt'){
				$stock=StockInOlt::where('srl_no',$srl_no)->first();
				if(count($stock)!=0){
					$status="true";
					$range="null";
				}else{
					$range="null";
					$status="false";
					$stock="Not Available !!!!";
				}
		}else if($material->material_details=='others'){
				$check=StockOthers::where('material_brand',$material_type)->get();
				foreach ($check as $key) {
					if($key->total!=$key->usage+$key->damage+$key->left_over){
						if($key->total>$final_c){
							$id[]=$key->id;
						}
					}
				}
				$stock=StockOthers::whereIn('id',$id)->first();
				if(count($stock)!=0){
					$status="true";
					$range="null";
				}else{
					$range="null";
					$status="false";
					$stock="Not Available !!!!";
				}
		}
		
		return Response::json(array('found' =>$status,'stock' =>$stock,'range'=>$range));
	}

	public function StockUpdate(){
		$data['stocks'] =StockCategory::all();
		$data['employees'] =Employee::all();
		return View::make('admin.switch_routers.stock_update',$data);
	}

	public function StockUpdateAjax(){

		$stock=DB::table('stock_category')->select('id','material_name','brand','material_type','material_details')->orderBy('id','desc');
        $stocks = Datatables::of($stock)->addColumn('update','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/switch_router/stock_update_det/{{$id}}">
																	<i class="label label-success arrowed">update</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
        return $stocks;

	}

	public function StockUpdateDet($id){

		$material=StockCategory::where('id',$id)->first();
		if($material->material_details=="fiber" || $material->material_details=="ethernet" || $material->material_details=="others"){
			$data['material']=$material;
			return View::make('admin.switch_routers.stock_update_meter',$data);	

		}else if($material->material_details=="onu" || $material->material_details=="olt" || $material->material_details=="router" ||$material->material_details=="switch"){
			$data['material']=$material;
			$data['employees']=Employee::all();
			return View::make('admin.switch_routers.stock_update_device',$data);		
		}
	}

	public function StockUpdates(){
		
		$ids=Input::get('id');

		$material=StockCategory::where('id',$ids)->first();

		$type=$material->material_name.'-'.$material->brand;

		
		if($material->material_details=="fiber"){
				$stocks=StockInEmployees::select('id','employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->where('material_brand',$type)
									->groupBy('id')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('id','desc')->get();
				 	foreach ($stocks as $key) {
				 			$check[]=$key->id;
				 	}
				 	if(count($stocks)==0){
		 				$check[]=null;
		 			}
		 $stock=StockInEmployees::select('employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->whereIn('id',$check)
									->where('material_brand',$type)
									->groupBy('employee_identity')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('employee_identity','desc');
		 							
		return Datatables::of($stock)->addColumn('Update','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/switch_router/stock_emp_update/{{$employee_identity}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">Update</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
		}else if($material->material_details=='ethernet'){
			$stocks=StockInEmployees::select('id','employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->where('material_brand',$type)
									->groupBy('id')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('id','desc')->get();
		 		
				 	foreach ($stocks as $key) {
				 			$check[]=$key->id;
				 	}
				 	if(count($stocks)==0){
		 				$check[]=null;
		 			}
		 $stock=StockInEmployees::select('employee_identity','material_brand',DB::raw('sum(total_meter) as total'),DB::raw('sum(used+damage+left_over) as sub_total'))
									->where('material_brand',$type)
									->whereIn('id',$check)
									->groupBy('employee_identity')
		 							->havingRaw('sum(total_meter) > sum(used+damage+left_over)')
		 							->orderBy('employee_identity','desc');
		 							
		return Datatables::of($stock)->addColumn('Update','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/switch_router/stock_emp_update/{{$employee_identity}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">Update</i>
																</a>&nbsp;&nbsp;
															</div',false)->make();
		 							
		}else if($material->material_details=='onu'){

				$stock=StockInOnu::select('id','onu_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('used_type','<div class="col-sm-2">
													                        <select name="used_type[]" class="form-control used_type{{$id}}" onchange="UsedType({{$id}})">
													                            <option value="">Select Usage Type</option>
													                            <option value="new_customers">New customers</option>
													                            <option value="exist_customers">Exist customers</option>
													                            <option value="damage">damage</option>
													                            <option value="left_over">left over</option>
													                        </select>
														                </div>',false)
							
											->addColumn('update_to','<input type="text" name="crf_acc" placeholder="Update To" class="form-control crf_acc{{$id}}" readonly="true"/>',false)
											->addColumn('update','@if(DB::table("stock_in_onu")->where("id",$id)->first()->complete==0)
		 															<span class="btn btn-minier btn-success" onclick=updates("update",{{$id}})>Update</span>
																	@else
																	<span class="btn btn-minier btn-danger" onclick=updates("update",{{$id}})>Updated</span>
																	@endif',false)
											->addColumn('assign','<span class="btn btn-minier btn-success" onclick=updates("assign",{{$id}})>Assign</span>',false)
											->addColumn('accept','@if(DB::table("stock_in_onu")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success" onclick=updates("accept",{{$id}})>Accept</span>
																	@else
		 															<span class="btn btn-minier btn-danger" onclick=updates("accept",{{$id}})>Accepted</span>
																	@endif',false)->make();
		
		}else if($material->material_details=='router'){

				$stock=StockInRouter::select('id','router_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('used_type','<div class="col-sm-2">
													                        <select name="used_type[]" class="form-control used_type{{$id}}" onchange="UsedType({{$id}})">
													                            <option value="">Select Usage Type</option>
													                            <option value="new_customers">New customers</option>
													                            <option value="exist_customers">Exist customers</option>
													                            <option value="damage">damage</option>
													                            <option value="left_over">left over</option>
													                        </select>
														                </div>',false)
							
											->addColumn('update_to','<input type="text" name="crf_acc" placeholder="Update To" class="form-control crf_acc{{$id}}" readonly="true"/>',false)
											->addColumn('update','@if(DB::table("stock_in_router")->where("id",$id)->first()->complete==0)
		 															<span class="btn btn-minier btn-success" onclick=updates("update",{{$id}})>Update</span>
																	@else
																	<span class="btn btn-minier btn-danger" onclick=updates("update",{{$id}})>Updated</span>
																	@endif',false)
											->addColumn('assign','<span class="btn btn-minier btn-success" onclick=updates("assign",{{$id}})>Assign</span>',false)
											->addColumn('accept','@if(DB::table("stock_in_router")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success" onclick=updates("accept",{{$id}})>Accept</span>
																	@else
		 															<span class="btn btn-minier btn-danger" onclick=updates("accept",{{$id}})>Accepted</span>
																	@endif',false)->make();
		}else if($material->material_details=='switch'){

				$stock=StockInSwitch::select('id','switch_id','material_brand','srl_no','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('used_type','<div class="col-sm-2">
													                        <select name="used_type[]" class="form-control used_type{{$id}}" onchange="UsedType({{$id}})">
													                            <option value="">Select Usage Type</option>
													                            <option value="new_customers">New customers</option>
													                            <option value="exist_customers">Exist customers</option>
													                            <option value="damage">damage</option>
													                            <option value="left_over">left over</option>
													                        </select>
														                </div>',false)
							
											->addColumn('update_to','<input type="text" name="crf_acc" placeholder="Update To" class="form-control crf_acc{{$id}}" readonly="true"/>',false)
											->addColumn('update','@if(DB::table("stock_in_switch")->where("id",$id)->first()->complete==0)
		 															<span class="btn btn-minier btn-success" onclick=updates("update",{{$id}})>Update</span>
																	@else
																	<span class="btn btn-minier btn-danger" onclick=updates("update",{{$id}})>Updated</span>
																	@endif',false)
											->addColumn('assign','<span class="btn btn-minier btn-success" onclick=updates("assign",{{$id}})>Assign</span>',false)
											->addColumn('accept','@if(DB::table("stock_in_switch")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success" onclick=updates("accept",{{$id}})>Accept</span>
																	@else
		 															<span class="btn btn-minier btn-danger" onclick=updates("accept",{{$id}})>Accepted</span>
																	@endif',false)->make();
		}else if($material->material_details=='olt'){
				
				$stock=StockInOlt::select('id','olt_id','material_brand','srl_no','mac_address','sender','receiver')->where('complete',0)->orderBy('id','desc');
				return Datatables::of($stock)->addColumn('used_type','<div class="col-sm-2">
													                        <select name="used_type[]" class="form-control used_type{{$id}}" onchange="UsedType({{$id}})">
													                            <option value="">Select Usage Type</option>
													                            <option value="new_customers">New customers</option>
													                            <option value="exist_customers">Exist customers</option>
													                            <option value="damage">damage</option>
													                            <option value="left_over">left over</option>
													                        </select>
														                </div>',false)
							
											->addColumn('update_to','<input type="text" name="crf_acc" placeholder="Update To" class="form-control crf_acc{{$id}}" readonly="true"/>',false)
											->addColumn('update','@if(DB::table("stock_in_olt")->where("id",$id)->first()->complete==0)
		 															<span class="btn btn-minier btn-success" onclick=updates("update",{{$id}})>Update</span>
																	@else
																	<span class="btn btn-minier btn-danger" onclick=updates("update",{{$id}})>Updated</span>
																	@endif',false)
											->addColumn('assign','<span class="btn btn-minier btn-success" onclick=updates("assign",{{$id}})>Assign</span>',false)
											->addColumn('accept','@if(DB::table("stock_in_olt")->where("id",$id)->first()->wait==1)
																	<span class="btn btn-minier btn-success" onclick=updates("accept",{{$id}})>Accept</span>
																	@else
		 															<span class="btn btn-minier btn-danger" onclick=updates("accept",{{$id}})>Accepted</span>
																	@endif',false)->make();	
		}else if($material->material_details=='others'){

				$stocks=StockOtherEmp::select('id','material_brand',DB::raw('sum(total) as total'),DB::raw('sum(damage+left_over+used) as sub_total'))
										->where('material_brand',$type)
										->groupBy('id')
			 							->havingRaw('sum(total) > sum(used+damage+left_over)')
			 							->get();
			 	foreach ($stocks as $key) {
		 			$check[]=$key->id;
		 		}
		 		if(count($stocks)==0){
		 			$check[]=null;
		 		}

			 	$stock=StockOtherEmp::select('employee_identity','material_brand',DB::raw('sum(total) as total'),DB::raw('sum(damage+left_over+used) as sub_total'))
										->whereIn('id',$check)
										->where('material_brand',$type)
										->groupBy('employee_identity')
			 							->havingRaw('sum(total) > sum(used+damage+left_over)')
			 							->orderBy('employee_identity','desc');
		 		return Datatables::of($stock)->addColumn('Update','<div class="hidden-sm hidden-xs btn-group">
																<a href="/admin/switch_router/stock_emp_update/{{$employee_identity}}?material={{$material_brand}}">
																	<i class="label label-success arrowed">Update</i>
																</a>&nbsp;&nbsp;
															</div>',false)->make();
		}

					
	}

	public function StockEmployUpdate($id){
		$material_type=Input::get('material');


		$types=explode('-',$material_type);

		$material=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();
		if($material->material_details=="fiber"){
			$stock=StockInEmployees::where('employee_identity',$id)->where('material_brand',$material_type)->get();
			foreach ($stock as $key) {
				if($key->total_meter!=($key->used+$key->left_over+$key->damage)){
				$exist[$key->id]=array('id'=>$key->id,'type' => $material_type,'drum_no'=>$key->drum_no,'start_meter'=>$key->start_meter,'end_meter'=>$key->end_meter,'total_meter'=>$key->total_meter
							,'used'=>$key->used,'damage'=>$key->damage,'left_over'=>$key->left_over);
				}
			}
			if(count($stock)==0){
		 			$exist[]=null;
		 		}
			$data['material_details']=$material->material_details;
			$data['meters']=$exist;
			return View::make('admin.switch_routers.emp_update_meter',$data);	
		}else if($material->material_details=="ethernet"){
			$stock=StockInEmployees::where('employee_identity',$id)->where('material_brand',$material_type)->get();
			foreach ($stock as $key) {
				if($key->total_meter!=($key->used+$key->left_over+$key->damage)){
				$exist[$key->id]=array('id'=>$key->id,'type' =>$material_type,'drum_no'=>$key->drum_no,'start_meter'=>$key->start_meter,'end_meter'=>$key->end_meter,'total_meter'=>$key->total_meter
							,'used'=>$key->used,'damage'=>$key->damage,'left_over'=>$key->left_over);
				}
			}
			if(count($stock)==0){
		 			$exist[]=null;
		 		}
			$data['material_details']=$material->material_details;
			$data['meters']=$exist;
			return View::make('admin.switch_routers.emp_update_meter',$data);
		}else if($material->material_details=="others"){
			$stock=StockOtherEmp::where('employee_identity',$id)->where('material_brand',$material_type)->get();
			foreach ($stock as $key) {
				if($key->total!=($key->used+$key->left_over+$key->damage)){
				$exist[$key->id]=array('id'=>$key->id,'type' => $material_type,'total'=>$key->total
							,'used'=>$key->used,'damage'=>$key->damage,'left_over'=>$key->left_over);
				}
			}
			if(count($stock)==0){
		 			$exist[]=null;
		 		}
			$data['material_details']=$material->material_details;
			$data['meters']=$exist;
			return View::make('admin.switch_routers.emp_update_count',$data);
			
		}


	}


	public function countDetails(){

		$material_type=Input::get('material');

		$types=explode('-',$material_type);

		$stock=StockCategory::where('material_name',$types[0])->where('brand',$types[1])->first();

		if(count($stock)!=0){
			$response = array('type' =>$stock->material_type);
			return Response::json($response);
		}else{
			return Response::json(array('found' => "false"));
		}

	}

	public function StockUpdateDevice(){
		$s_id=Input::get('s_id');
		$up_id=Input::get('up_id');
		$use_type=Input::get('use_type');
		$crf=Input::get('crf');
		$employee=Input::get('employee');

		$material=StockCategory::where('id',$s_id)->first();

		if($material->material_details=='onu'){
				$onu=StockInOnu::where('id',$up_id)->first();
				if($use_type=="assign"){
					$onu->receiver=$employee;
					$onu->sender=Auth::employee()->get()->employee_identity;
					$onu->wait=1;
					$onu->process=1;
				}else if($use_type=="accept"){
					$onu->wait=0;
				}else if($use_type=="damage"){
					$onu->damage=1;
				}else if($use_type=="left_over"){
					$onu->left_over=1;
				}else{
					if($use_type=="new_customers"){
						$cust=StockOutCustomers::where('crf_no',$crf)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->crf_no=$crf;
						}
					}else if($use_type=="exist_customers"){
						$acc=$crf;
						$cust=StockOutCustomers::where('account_id',$acc)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->account_id=$acc_id;
						}
					} 
					$cust->onu_id=$onu->onu_id;
					$cust->save();
					$onu->complete=1;
			}
			$onu->save();
		}else if($material->material_details=='router'){
				$router=StockInRouter::where('id',$up_id)->first();
				if($use_type=="assign"){
					$router->receiver=$employee;
					$router->sender=Auth::employee()->get()->employee_identity;
					$router->wait=1;
					$router->process=1;
				}else if($use_type=="accept"){
					$router->wait=0;
				}else if($use_type=="damage"){
					$router->damage=1;
				}else if($used_type[$i]=="left_over"){
					$router->left_over=1;
				}else{
					if($use_type=="new_customers"){
						$cust=StockOutCustomers::where('crf_no',$crf)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->crf_no=$crf;
						}
					}else if($use_type=="exist_customers"){
						$acc=$crf;
						$cust=StockOutCustomers::where('account_id',$acc)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->account_id=$acc;
						}
					} 
					$cust->router_id=$router->rotuer_id;
					$cust->save();
					$router->complete=1;
				}
				$router->save();
		}else if($material->material_details=='switch'){
				$switch=StockInSwitch::where('id',$up_id)->first();
				if($use_type=="assign"){
					$switch->receiver=$employee;
					$switch->sender=Auth::employee()->get()->employee_identity;
					$switch->wait=1;
					$switch->process=1;
				}else if($use_type=="accept"){
					$switch->wait=0;
				}else if($use_type=="damage"){
					$switch->damage=1;
				}else if($use_type=="left_over"){
					$switch->left_over=1;
				}else{
					if($use_type=="new_customers"){
						$cust=StockOutCustomers::where('crf_no',$crf)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->crf_no=$crf;
						}
					}else if($used_type[$i]=="exist_customers"){
						$acc=$crf;
						$cust=StockOutCustomers::where('account_id',$acc)->first();
						if(!$cust){
							$cust=new StockOutCustomers();
							$cust->account_id=$acc;
						}
					} 
					$cust->switch_id=$switch->switch_id;
					$cust->save();
					$switch->complete=1;
				}
				$switch->save();
		}else if($material->material_details=='olt'){
				$olt=StockInOlt::where('id',$up_id)->first();
				if($use_type=="assign"){
					$olt->receiver=$employee;
					$olt->sender=Auth::employee()->get()->employee_identity;
					$olt->wait=1;
					$olt->process=1;
				}else if($use_type=="accept"){
					$olt->wait=0;
				}else if($use_type=="damage"){
					$olt->damage=1;
				}else if($use_type=="left_over"){
					$olt->left_over=1;
				}else{
					$olt->complete=1;
				}
				$olt->save();
		}

			$response = array('found' => "true");
			return Response::json($response);

	}


	public function UpdateStock(){

		$material_details=Input::get('material_details');
		$date=Input::get('date');
		
		$e_id=Input::get('e_id');
		$e_drum_no=Input::get('e_drum_no');
		$e_used=Input::get('e_used');
		$e_damage=Input::get('e_damage');
		$e_left_over=Input::get('e_left_over');

		$crf_no=Input::get('crf_no');
		$account_id=Input::get('account_id');
		
		$id=Input::get('id');
		$drum_no=Input::get('drum_no');
		$from=Input::get('from_meter');
		$to=Input::get('to_meter');
		$total=Input::get('total_meter');

		$used_type=Input::get('used_type');

		$count=Input::get('total');
		

		if($material_details=='fiber'){
			for($i=0;$i< count($id) ;$i++) {
				if($id[$i]!=''){
					$stockin=StockInFiber::where('drum_no',$drum_no[$i])->first();
					$stockin->used=$e_used[$i]+$stockin->used;
					$stockin->damage=$e_damage[$i]+$stockin->damage;
					$stockin->left_over=$e_left_over[$i]+$stockin->left_over;
					$stockin->save();
					$fiber=StockInEmployees::where('id',$id[$i])->first();
					$fiber->used=$e_used[$i];
					$fiber->damage=$e_damage[$i];
					$fiber->left_over=$e_left_over[$i];
					$fiber->save();
					if($used_type[$i]!="damage" && $used_type[$i]!="left_over"){
						if($used_type[$i]=="new_customers"){
							$cust=StockOutCustomers::where('crf_no',$crf_no[$i])->first();
							if(!$cust){
								$cust=new StockOutCustomers();
								$cust->crf_no=$crf_no[$i];
							}
						}else if($used_type[$i]=="exist_customers"){
							$cust=StockOutCustomers::where('account_id',$account_id[$i])->first();
							if(!$cust){
								$cust=new StockOutCustomers();
								$cust->account_id=$account_id[$i];
							}
						} 
						$cust->fiber_start_meter=$from[$i]+$cust->fiber_start_meter;
						$cust->fiber_end_meter=$to[$i]+$cust->fiber_start_meter;
						$cust->fiber_drum_no=$drum_no[$i];
						$cust->save();
					}

				}
			}
		}else if($material_details=='ethernet'){
			for($i=0;$i< count($id) ;$i++) {
				if($id[$i]!=''){
					$stockin=StockInEthernet::where('drum_no',$drum_no[$i])->first();
					$stockin->used=$e_used[$i]+$stockin->used;
					$stockin->damage=$e_damage[$i]+$stockin->damage;
					$stockin->left_over=$e_left_over[$i]+$stockin->left_over;
					$stockin->save();
					$ethernet=StockInEmployees::where('id',$id[$i])->first();
					$ethernet->used=$e_used[$i];
					$ethernet->damage=$e_damage[$i];
					$ethernet->left_over=$e_left_over[$i];
					$ethernet->save();
					if($used_type[$i]!="damage" && $used_type[$i]!="left_over"){
						if($used_type[$i]=="new_customers"){
							$cust=StockOutCustomers::where('crf_no',$crf_no[$i])->first();
							if(!$cust){
								$cust=new StockOutCustomers();
								$cust->crf_no=$crf_no[$i];
							}
						}else if($used_type[$i]=="exist_customers"){
							$cust=StockOutCustomers::where('account_id',$account_id[$i])->first();
							if(!$cust){
								$cust=new StockOutCustomers();
								$cust->account_id=$account_id[$i];
							}
						} 
						$cust->ethernet_start_meter=$from[$i]+$cust->ethernet_start_meter;
						$cust->ethernet_end_meter=$to[$i]+$cust->ethernet_end_meter;
						$cust->ethernet_drum_no=$drum_no[$i];
						$cust->save();
					}
				}
			}
		}else if($material_details=='others'){
			for($i=0;$i< count($id) ;$i++) {
				if($id[$i]!=''){
					$stockin=StockOtherEmp::where('id',$id[$i])->first();
					$stockin->used=$e_used[$i]+$stockin->used;
					$stockin->damage=$e_damage[$i]+$stockin->damage;
					$stockin->left_over=$e_left_over[$i]+$stockin->left_over;
					$stockin->save();
					$others=StockOthers::where('id',$stockin->stock_others_id)->first();
					if($used_type[$i]=="damage"){
						$others->damage=$count[$i]+$others->damage;
					}else if($used_type[$i]=="left_over"){
						$others->left_over=$count[$i]+$others->left_over;
					}else{
						if($used_type[$i]=="new_customers"){
							$cust=StockOtherCust::where('crf_no',$crf_no[$i])->first();
							if(!$cust){
								$cust=new StockOtherCust();
								$cust->crf_no=$crf_no[$i];
							}
						}else if($used_type[$i]=="exist_customers"){
							$cust=StockOtherCust::where('account_id',$account_id[$i])->first();
							if(!$cust){
								$cust=new StockOtherCust();
								$cust->account_id=$account_id[$i];
							}
						} 
						$cust->used=$count[$i]+$cust->used;
						$cust->stock_others_id=$others->id;
						$cust->save();
						$others->used=$count[$i]+$others->used;
					}
					$others->save();
				}
			}
		}
		return View::make('admin.switch_routers.stock_update');

	}



	public function CheckPreActivation(){

		$crf=Input::get('x');

		$pre=PreActivationStatus::where('crf_no',$crf)->first();
		if(!$pre){
			$pre=CusDet::where('account_id',$crf)->first();
		}
		if(count($pre)!=0){
			$response = array('found' => "true");
			return Response::json($response);
		}else{
			return Response::json(array('found' => "false"));
		}
	}

	public function index(){
		
		return View::make('admin.switch_routers.index');	
	}

	public function switchRouterAjax(){

		$routers= DB::table('switch_routers_det')->select('device_id','catagory_type','device_type',
							'manufacture','srl_no','mac_address','remarks','created_by');
		$routers_switch= Datatables::of($routers)->make();
		
		return $routers_switch;
	}

	public function create(){
		$data['employees']=Employee::all();
		return View::make('admin.switch_routers.create',$data);
	}

	public function store(){
		$router=new SwitchRouter();
		$router->device_id=Input::get('device_id');
		$router->catagory_type=Input::get('catagory_type');
		$router->device_type=Input::get('device_type');
		$router->mac_address=Input::get('mac_address');
		$router->srl_no=Input::get('srl_no');
		$router->manufacture=Input::get('manufacture');
		$router->remarks=Input::get('remarks');
		$router->created_by=Auth::employee()->get()->employee_identity;
		if($router->save()) {
		return Redirect::to('/admin/switch-router/index')
				->with('success','Switch and Routers added Succesfully');
		
		}
		return Redirect::to('/admin/switch-router/create')
				->with('failure','Switch and Routers Not added');
	}

		public function TAGindex(){
		
		return View::make('admin.switch_routers.index_tag');	
	}

	public function TAGswitchRouterAjax(){

		$routers= DB::table('switch_routers_id_det')->select('account_id','ht_box_id',
							'onu_id','switch_id','router_id','sign_up_employee','created_by');
		$routers_switch= Datatables::of($routers)->make();
		
		return $routers_switch;
	}

	public function TAGcreate(){
		$data['employees']=Employee::all();
		return View::make('admin.switch_routers.create_tag',$data);
	}

	public function TAGstore(){
		$router=new SwitchRouterId();
		$router->ht_box_id=Input::get('ht_box_id');
		$router->onu_id=Input::get('onu_id');
		$router->switch_id=Input::get('switch_id');
		$router->router_id=Input::get('router_id');
		$router->account_id=Input::get('account_id');
		$router->sign_up_employee=Input::get('sign_up_employee');
		$router->created_by=Input::get('created_by');
		if($router->save()) {
		return Redirect::to('/admin/switch_router-tag/index')
				->with('success','Switch and Routers added Succesfully');
		
		}
		return Redirect::to('/admin/switch_router-tag/create')
				->with('failure','Switch and Routers Not added');
	}
}