@extends ('admin.layouts.default')
@section('main')
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="/admin/index">Home</a>
		</li>
		<li class="active">
			<a href="/admin/switch-router/stock_in">Stock In</a>
		</li>
	</ul>
</div>
	<div class="page-header">
		<h1>
			Stock Update
		</h1>
	</div>
<div class="col-sm-12">
	{{ Form::open( array( 'route' => array('admin.switch_router.update_stock'), 'method' => 'POST','class' => 'form-horizontal validate-form', 'role' => 'form')  ) }}
		<input type="hidden" name='material_details' value="{{$material_details}}" class="form-control" readonly="true"/>
		@foreach($meters as $meter)
				<div class="meter">
					<div class="col-sm-12">
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;ID</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;TYPE</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;DRUM NO</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;FORM</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;TO</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;TOTAL</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;USED</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;LEFTOVER</h5>
						<h5 class="col-sm-1 blue">&nbsp;&nbsp;&nbsp;DAMAGE</h5>
					</div>
				</div>
		<div class="form-group col-sm-12 well">
				<div class="col-sm-1">
		        	<input type="text" name="e_id[]" value="{{$meter['id']}}" placeholder="ID" class="form-control e_id{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="type[]" value="{{$meter['type']}}" placeholder="Type" class="form-control type{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_drum_no[]" value="{{$meter['drum_no']}}" placeholder="Drum No" class="form-control e_drum_no{{$meter['id']}}" readonly="true"/>
		        </div>	
		        <div class="col-sm-1">
		        	<input type="text" name="e_from_meter[]" value="{{$meter['start_meter']}}" placeholder="From Meter" class="form-control e_start{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_to_meter[]" value="{{$meter['end_meter']}}" placeholder="To Meter" class="form-control e_end{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_total_meter[]" value="{{$meter['total_meter']}}"  placeholder="Total Meter" class="form-control e_total{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_used[]" value="{{$meter['used']}}"  placeholder="Used" class="form-control e_used{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_damage[]" value="{{$meter['damage']}}" placeholder="Damage" class="form-control e_damage{{$meter['id']}}" readonly="true"/>
		        </div>
		        <div class="col-sm-1">
		        	<input type="text" name="e_left_over[]" value="{{$meter['left_over']}}"  placeholder="Left over" class="form-control e_left{{$meter['id']}}" readonly="true"/>
		        </div>
				<span class="btn btn-white btn-info btn-bold pull-right update{{$meter['id']}}">
				    <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
				    Update
				</span>
				@include('admin.switch_routers.meter_update')
				<script type="text/javascript">
				        $('span.update{{$meter["id"]}}').click(function(){
				            $(".show_form{{$meter['id']}}").slideToggle("speed");
				        });
				</script>
		</div>
	@endforeach
		<div class="center">
			{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
		</div>
	{{ Form::close(); }}
</div>
<script type="text/javascript">
	$("body").on("click", ".delete", function (e) {
        $(this).parent("div").remove();

 	});
	function addMeter(t,x){
 		var y=$('.find_count'+t).val();
 		i=+y+1;
        $(".update_meter"+t).append('<div class="form-group col-sm-12"><div class="col-sm-2" ><select name="used_type[]" class="form-control used_type'+t+i+'" onchange="UsedType('+t+','+i+')"><option value="">Select Usage Type</option><option value="new_customers">New customers</option><option value="exist_customers">Exist customers</option><option value="damage">damage</option><option value="left_over">left over</option></select></div><div class="col-sm-2"><input type="text" name="crf_no[]"  placeholder="CRF NO" class="form-control crf_no'+t+i+'" readonly="true"/></div><div class="col-sm-2"><input type="text" name="account_id[]"  placeholder="Account id" class="form-control account_id'+t+i+'" readonly="true"/></div><div class="col-sm-1"><input type="text" name="id[]"  placeholder="ID" class="form-control id'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="drum_no[]"  placeholder="Drum No" class="form-control drum_no'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="from_meter[]" placeholder="From Meter" class="form-control from_meter'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="to_meter[]" placeholder="To Meter" class="form-control to_meter'+t+i+'" onchange="TotalMeterCalc('+t+','+(i+1)+')" /></div><div class="col-sm-1"><input type="text" name="total_meter[]" placeholder="Total Meter" class="form-control t_meter'+t+i+'" readonly="true"/></div><span class="btn btn-minier btn-primary delete">DELETE</span></div></div>');
 		$('.find_count'+t).val(i);
 	}

 	function UsedType(t,x){
 	if($('.used_type'+t+x).val()=="new_customers"){
 		$('.account_id'+t+x).attr('readonly',true);
 		$('.crf_no'+t+x).attr('readonly',false);
 	}else if($('.used_type'+t+x).val()=="exist_customers"){
 		$('.crf_no'+t+x).attr('readonly',true);
 		$('.account_id'+t+x).attr('readonly',false);
 	}else{
 		$('.account_id'+t+x).attr('readonly',true);
 		$('.crf_no'+t+x).attr('readonly',true);
 	}
 }
</script>

<script type="text/javascript">
	function TotalMeterCalc(t,x){
	var start_meter=$('.from_meter'+t+x).val();
	var end_meter=$('.to_meter'+t+x).val();
	var used_type=$('.used_type'+t+x).val();
	var drum_no=$('.drum_no'+t+x).val();
	var e_start=$('.e_start'+t).val();
	var e_end=$('.e_end'+t).val();

	var e_tot=$('.e_total'+t).val();
	var use=$('.e_used'+t).val();
	var dam=$('.e_damage'+t).val();
	var left=$('.e_left'+t).val();
	var totalmeter= start_meter - end_meter;
    if(totalmeter < 0){
    	var meter=(-1*totalmeter);	
    }else{
    	var meter=(1*totalmeter);
    }
	var have= +use+ +dam+ +left+ meter;
	
	if(used_type.length!=0 && start_meter.length!=0 && end_meter.length!=0 && drum_no.length!=0){
		if($('.e_drum_no'+t).val()==drum_no && $('.id'+t+x).val()==t){
			if(used_type=="new_customers"){
				 var crf_no=$('.crf_no'+t+x).val();
				 if(crf_no){
				 	CheckPreActivation(crf_no);
				 	if(e_start<=start_meter && e_tot >= have && +e_end >= +end_meter){
				        
				        $('.t_meter'+t+x).val(meter);
				        $('.e_used'+t).val(meter+ +use);
					}else{
						alert('Error Meter not in the existing range !!!!');
					}
				 }else{
				 	alert("please enter crf no !!!!!")
				 }

			}else if(used_type=="exist_customers"){
				var account_id=$('.account_id'+t+x).val();
				 if(account_id){
				 	CheckPreActivation(account_id);
				 	if(e_start<=start_meter && e_tot >= have && +e_end >= +end_meter){
						
				        $('.t_meter'+t+x).val(meter);
				         $('.e_used'+t).val(meter+ +use);
					}else{
						alert('Error Meter not in the existing range !!!!');
					}
				 }else{
				 	alert("please enter account_id !!!!!")
				 }
			}else if(used_type=="damage"){
				 	if(start_meter.length!=0 && end_meter.length!=0 && e_tot >= have){
						
				        $('.t_meter'+t+x).val(meter);
				         $('.e_damage'+t).val(meter+ +dam);
					}else{
						alert('Error Meter not in the existing range !!!!');
					}
			}else if(used_type=="left_over"){
				 	if(start_meter.length!=0 && end_meter.length!=0 && e_tot >= have){
				        
				        $('.t_meter'+t+x).val(meter);
				        $('.e_left_over'+t).val(meter+ +left);
					}else{
						alert('Error Meter not in the existing range !!!!');
					}
			}
		}else{
			alert("Invaild Drum No !!!!");	
		}
	}else{
		alert("Please Select User Type and From To meter and Drum No");
	}
}

function CheckPreActivation(x){
	$.ajax({
            url : '/admin/switch_router/check_preactivation',
            type : 'get',
            data : { 'x':x },
           success : function(data) {
           		if (data["found"] == "false") {
                	alert('Invaild Crf and Account ID !!!!');
           		}
       		}
         });
	} 
</script>
@stop