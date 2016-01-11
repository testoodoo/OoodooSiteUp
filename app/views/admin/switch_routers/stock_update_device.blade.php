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
			<a href="/admin/switch_router/stock_update">Stock Update</a>
		</li>
	</ul>
</div>
<div class="page-header">
	<h1>
		Stock Update
	</h1>
</div>
{{ Form::hidden('id',$material->id, array('class' => 'col-xs-10 col-sm-5 id')) }}
{{ Form::hidden('type',$material->material_details, array('class' => 'col-xs-10 col-sm-5 type')) }}
<div class="col-sm-12">
	 <div class="col-sm-9"></div>
	<label class="col-sm-3 control-label">
            <span class="blue bolder">Select To Assign Employee</span>
            <select name="assign_employee" class="select2 employee"
                                             data-placeholder="Sales Employee">
                <option value="">Select Employee</option>
                @foreach($employees as $key)
                    <option value="{{$key->employee_identity}}">{{$key->name}}</option>
                @endforeach
            </select>
    </label>
</div>
<div class="col-sm-12">
	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Onu ID</th>
				<th>Material Brand</th>
				<th>Srl No</th>
				<th class="switch">Mac Address</th>
				<th>Sender</th>
				<th>Receiver</th>
				<th>Used Type</th>
				<th>Update To</th>
				<th>Update</th>
				<th>Assign</th>
				<th>Accept</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			</tr>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
            var type=$('.type').val();
            var id=$('.id').val();
            if($('.type').val()=="switch"){
            	$('.switch').remove();
            }
           var oTable = jQuery('#sample-table-1').dataTable({
    			processing: true,
            	serverSide: true,
            	autoWidth: false,
                       "ajax": '/admin/switch_router/stock_updates?id='+id+'&type='+type,
                       "type":'get',
         
    		});
	 });

	function UsedType(x){
	 	if($('.used_type'+x).val()=="new_customers"){
	 		$('.crf_acc'+x).attr('readonly',false);
	 		$('.crf_acc'+x).attr('placeholder',"CRF NO");
	 	}else if($('.used_type'+x).val()=="exist_customers"){
	 		$('.crf_acc'+x).attr('readonly',false);
	 		$('.crf_acc'+x).attr('placeholder',"Account ID");
	 	}else{
	 		$('.crf_acc'+x).attr('readonly',true);
	 		$('.crf_acc'+x).attr('placeholder',"Update To");
	 	}
	 }
</script>
<script type="text/javascript">
	function updates(t,x){
		alert(t);
		var s_id=$('.id').val();
		var up_id=x;
		var use_type=$('select.used_type'+x).val();
		var employee=$('select.employee').val();
		var crf=$('.crf_acc'+x).val();

		if($('.used_type'+x).val()=="new_customers"){
			CheckPreActivation(crf);
	 	}else if($('.used_type'+x).val()=="exist_customers"){
			CheckPreActivation(crf);
	 	}

	 	if(t=="update"){
	 		if (use_type.length !=0) {
	 			updatein(s_id,up_id,use_type,crf,employee)
	 		}else{
	 			alert("Please Select Used Type !!!!!!")
	 		}

	 	}else if(t=="assign"){

	 		if (employee.length !=0) {
	 			updatein(s_id,up_id,"assign",crf,employee)
	 		}else{
	 			alert("Please Select Employee !!!!!!")
	 		}

	 	}else if(t=="accept"){
	 		updatein(s_id,up_id,"accept",crf,employee)
	 	}

	}

	function updatein(s_id,up_id,use_type,crf,employee){
	$.ajax({
        url : '/admin/switch_router/stock_update_device',
        type : 'get',
        data : { 's_id':s_id ,'up_id':up_id ,'use_type' : use_type ,'crf' : crf,'employee' :employee },
       success : function(data) {
       		if (data["found"] == "false") {
            	alert('Invaild Crf and Account ID !!!!');
       		}
   		}
     });
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
@include('admin.partials.js_validation');
@stop