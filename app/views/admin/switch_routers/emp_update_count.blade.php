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
			Stock Update Mani
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
	        	<input type="text" name="e_total[]" value="{{$meter['total']}}"  placeholder="Total Meter" class="form-control e_total{{$meter['id']}}" readonly="true"/>
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
			@include('admin.switch_routers.count_update')
			<script type="text/javascript">
			        $('span.update{{$meter['id']}}').click(function(){
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
        $(".update_meter"+t).append('<div class="form-group col-sm-12"><div class="col-sm-2" ><select name="used_type[]" class="form-control used_type'+t+i+'" onchange="UsedType('+t+','+i+')"><option value="">Select Usage Type</option><option value="new_customers">New customers</option><option value="exist_customers">Exist customers</option><option value="damage">damage</option><option value="left_over">left over</option></select></div><div class="col-sm-2"><input type="text" name="crf_no[]"  placeholder="CRF NO" class="form-control crf_no'+t+i+'" readonly="true"/></div><div class="col-sm-2"><input type="text" name="account_id[]"  placeholder="Account id" class="form-control account_id'+t+i+'" readonly="true"/></div><div class="col-sm-1"><input type="text" name="id[]"  placeholder="ID" class="form-control id'+t+i+'"/></div><div class="col-sm-1"><input type="text" name="total[]" placeholder="Total Meter" class="form-control t_meter'+t+i+'" onchange="TotalCount('+t+','+i+')"/></div><span class="btn btn-minier btn-primary delete">DELETE</span></div></div>');
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

 	function TotalCount(t,x){
 		var e_met=$('.t_meter'+t+x).val();
 		var used_type=$('.used_type'+t+x).val();
 		var id=$('.id'+t+x).val();
 	if(e_met.length && used_type.length && id.length){

	 	if(t==$('.id'+t+x).val()){
	 		var e_tot=$('.e_total'+t).val();
	 		var use=$('.e_used'+t).val();
	 		var dam=$('.e_damage'+t).val();
	 		var left=$('.e_left'+t).val();
	 		var have= +use+ +dam+ +left+ +e_met;
	 		if(used_type=="new_customers"){
					 var crf_no=$('.crf_no'+t+x).val();
					 if(crf_no){
					 	CheckPreActivation(crf_no);
					 	if(e_tot > have){
					        var meter= +use+ +e_met;
					        $('.e_used'+t).val(meter);
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
					 	if(e_tot >= have){
					        var meter= +use+ +e_met;
					        $('.e_used'+t).val(meter);
						}else{
							alert('Error Meter not in the existing range !!!!');
						}
					 }else{
					 	alert("please enter account id !!!!!")
					 }
				}else if(used_type=="damage"){
					 	if(e_tot > have){
					        var meter= +dam+ +e_met;
					         $('.e_damage'+t).val(meter);
						}else{
							alert('Error Meter not in the existing range !!!!');
						}
				}else if(used_type=="left_over"){
					 	if(e_tot > have){
					        var meter= +left+ +e_met;
					         $('.e_left_over'+t).val(meter);
						}else{
							alert('Error Meter not in the existing range !!!!');
						}
				}
	 	}else{
	 		alert("ID Not Vaild !!!!");
	 	}
	 }else{
	 	alert("Please Select values in Used For and totat count and id !!!!!!");
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